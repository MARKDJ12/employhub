<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employhub";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally set the character set
$conn->set_charset("utf8");
