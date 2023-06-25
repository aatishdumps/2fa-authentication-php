<?php
$host = 'localhost';
$username = 'root';
$password = 'aatishk60';
$database = 'ci_pan';
$conn = new mysqli($host, $username, $password, $database);
if (!$conn)
    die("Could not connect to database server. Error : " . $conn->errno . " " . $conn->error);
