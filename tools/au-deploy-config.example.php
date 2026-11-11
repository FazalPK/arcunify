<?php
/**
 * Config for deploy-hook.php. Make a copy named au-deploy-config.php OUTSIDE this repo
 * (never commit it) and upload it ONE LEVEL ABOVE the WordPress root, i.e.
 * /home/teksetda/au-deploy-config.php. Use the same secret in GitHub → Settings → Webhooks.
 * Generate a secret in PowerShell:
 *   $b = New-Object byte[] 32; [Security.Cryptography.RandomNumberGenerator]::Create().GetBytes($b); -join ($b | % { $_.ToString('x2') })
 * The hook refuses to run while the secret is empty.
 */
return array(
	'secret' => '',
);
