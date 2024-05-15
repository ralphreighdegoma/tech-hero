<?php
// Define valid username and password
$valid_username = 'username';
$valid_password = 'password';

// Check if username and password are provided
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
    header('WWW-Authenticate: Basic realm="Restricted area"');
    header('HTTP/1.1 401 Unauthorized');
    echo 'Authorization Required';
    exit;
}

// Validate username and password
if ($_SERVER['PHP_AUTH_USER'] !== $valid_username || $_SERVER['PHP_AUTH_PW'] !== $valid_password) {
    header('HTTP/1.1 401 Unauthorized');
    echo 'Invalid username or password';
    header('WWW-Authenticate: Basic realm="Restricted area"');
    header('HTTP/1.1 401 Unauthorized');
    echo 'Authorization Required';
    exit;
}

// Authentication successful
//redirect to countries.php
header('Location: countries.php');
?>
