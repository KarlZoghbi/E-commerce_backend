<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

$host = "localhost";
$db_user = "root";
$db_pass = null;
$db_name = "e-commerce";

$mysqli = new mysqli($host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    echo "Connected successfully\n";
}

$check_db_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'";
$result = $mysqli->query($check_db_query);

if ($result->num_rows == 0) {
    die("Database '$db_name' does not exist.\n");
}


?>
