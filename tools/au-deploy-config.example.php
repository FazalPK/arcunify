<?php
/**
 * Config for deploy-hook.php. Copy to au-deploy-config.php and upload it ONE LEVEL ABOVE
 * the WordPress root (e.g. /home/teksetda/au-deploy-config.php), never inside public_html.
 * Use the same secret in GitHub → Settings → Webhooks.
 * Generate one in PowerShell:
 *   $b = New-Object byte[] 32; [Security.Cryptography.RandomNumberGenerator]::Create().GetBytes($b); -join ($b | % { $_.ToString('x2') })
 */
return array(
	'secret' => 'PASTE-A-RANDOM-SECRET-OF-AT-LEAST-32-CHARACTERS',
);
