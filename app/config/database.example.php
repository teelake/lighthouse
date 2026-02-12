<?php
/**
 * Database Configuration Example
 * Copy to database.php and update credentials
 */

return [
    'host' => 'localhost',
    'dbname' => 'lighthouse_church',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];
