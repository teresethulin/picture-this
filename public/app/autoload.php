<?php

declare(strict_types=1);

// Start the session engines.
session_start();

// Set the default timezone to coordinated universal time.
date_default_timezone_set('UTC');

// Set the default character encoding to UTF-8.
mb_internal_encoding('UTF-8');

// Include the helper functions.
require __DIR__ . '/functions.php';

// // Include error message function
// require __DIR__ . '/errors.php';

// // Include success message function
// require __DIR__ . '/successes.php';

// Fetch the global configuration array.
$config = require __DIR__ . '/config.php';

// Setup the database connection.
$pdo = new PDO($config['database_path']);
