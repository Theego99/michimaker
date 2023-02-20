<?php

$host = "testdiegoalonsowa5fg4.mysql.database.azure.com";
$dbname = "michimaker";
$username = "michimaker_admin";
$password = "ganarcielo123.";

$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;