<?php
// __DIR__ is now /public_html/public/ (the web root)
$publicDir = __DIR__;

// The symlink must live INSIDE the public/ folder
$linkPath = $publicDir . '/storage';

// The real storage files are one level up at /public_html/storage/app/public
$targetPath = dirname($publicDir) . '/storage/app/public';

// Remove any existing bad symlink
if (is_link($linkPath)) {
  unlink($linkPath);
  echo "Removed old bad symlink.<br>";
}

// Create the correct symlink
if (!file_exists($linkPath)) {
  if (symlink($targetPath, $linkPath)) {
    echo "✅ Symlink created successfully at: {$linkPath}<br>";
    echo "✅ Pointing to: {$targetPath}<br>";
    echo "<h2>Done! Your documents should now load correctly.</h2>";
  } else {
    echo "❌ Failed to create symlink. Check server permissions.";
  }
} else {
  echo "A 'storage' folder already exists and is not a symlink. Check FileZilla.";
}
