<?php
session_start(); // Start session

// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'employhub';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful, store username in session and redirect to dashboard
        $_SESSION["username"] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        // Login failed, display error message
        $error = "Invalid username or password";
    }
    $stmt->close();
}

$conn->close();
?>