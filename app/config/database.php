<?php
/**
 * Database Configuration
 * Copy database.example.php to database.local.php and set your credentials
 */
$localConfig = __DIR__ . '/database.local.php';
if (file_exists($localConfig)) {
    return require $localConfig;
}
return require __DIR__ . '/database.example.php';
