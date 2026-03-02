<?php
error_reporting(-1);

$servername = "localhost";
$username = "root";
$password = "";
$database = "u997410460_ratn0s1_ndh9";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ❌ DO NOT echo anything here


?>