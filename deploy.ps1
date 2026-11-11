# Deploy the ArcUnify theme to arcunify.com over FTPS (rclone remote "arcunify").
# The FTP account is rooted at /home/teksetda/arcunify.com/wp-content/themes/arcunify.
#
#   .\deploy.ps1 backup              download the server theme to ..\_backups\arcunify\<date-time>
#   .\deploy.ps1 check               list files that differ between this folder and the server
#   .\deploy.ps1 push -DryRun        show what would be uploaded
#   .\deploy.ps1 push                upload files that are newer here than on the server
#   .\deploy.ps1 push -Force         upload every file that differs, even if the server copy is newer
#
# Push never deletes files on the server. Run "backup" before a push.
# One-time setup: rclone config  ->  n) New remote, name "arcunify", type "ftp",
# host = your FTP host, user = full FTP username, password, explicit_tls = true.
param(
    [Parameter(Mandatory)][ValidateSet('backup', 'check', 'push')][string]$Action,
    [switch]$DryRun,
    [switch]$Force
)

# Not 'Stop': rclone logs to stderr and PowerShell 5.1 would treat that as a fatal error.
$ErrorActionPreference = 'Continue'
Set-Location $PSScriptRoot

$Remote = 'arcunify:'

$rclone = (Get-Command rclone -ErrorAction SilentlyContinue).Source
if (-not $rclone) {
    $rclone = Get-ChildItem "$env:LOCALAPPDATA\Microsoft\WinGet\Packages" -Recurse -Filter rclone.exe -ErrorAction SilentlyContinue |
        Select-Object -First 1 -ExpandProperty FullName
}
if (-not $rclone) { throw 'rclone not found. Install with: winget install Rclone.Rclone' }
if (-not ((& $rclone listremotes) -contains $Remote)) {
    throw "rclone remote '$Remote' is not set up. Run: rclone config (see the top of deploy.ps1)."
}

# Files that stay local: repo tooling, docs and logs.
$exclude = @(
    '--exclude', '.git/**',
    '--exclude', '.github/**',
    '--exclude', '.gitignore',
    '--exclude', '.gitattributes',
    '--exclude', '.vscode/**',
    '--exclude', 'tools/**',
    '--exclude', 'au-deploy-config.php',
    '--exclude', 'README.md',
    '--exclude', 'arcunify-conversation-export.md',
    '--exclude', 'deploy.ps1',
    '--exclude', 'build.sh',
    '--exclude', 'error_log',
    '--exclude', '*.log'
)
$flags = $exclude + @('--ftp-concurrency', '4')
if ($DryRun) { $flags += '--dry-run' }

switch ($Action) {
    'backup' {
        $dest = Join-Path $PSScriptRoot ("..\_backups\arcunify\" + (Get-Date -Format 'yyyy-MM-dd_HHmmss'))
        Write-Host "Backing up server theme to $dest" -ForegroundColor Cyan
        & $rclone copy $Remote $dest --ftp-concurrency 4 -v
    }
    'check' {
        & $rclone check . $Remote --size-only @exclude --ftp-concurrency 4 2>&1 |
            ForEach-Object { "$_" } | Where-Object { $_ -notmatch 'No common hash' }
    }
    'push' {
        # Default: only upload when the local file is newer, so edits made on the server are not
        # overwritten. -Force uploads every file whose size or date differs.
        if (-not $Force) { $flags += '--update' }
        & $rclone copy . $Remote @flags -v
    }
}
