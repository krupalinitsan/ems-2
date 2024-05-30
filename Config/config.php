<?php
// config/config.php
$host = "localhost";
$username = "root";
$password = "";
$database = "pms";

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

