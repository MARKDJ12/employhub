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
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="../img/ourlogo.png">
    <style>
        body {
            background-image: url('path.jpeg');
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 300px;
            margin: 200px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.5); /* Transparent background */
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);

        }
        .container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .container label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .container input[type="text"],
        .container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .field-icon {
            float: right;
            margin-left: -25px;
            margin-top: -25px;
            position: relative;
            z-index: 2;
        }
        .error {
            color: #f00;
            text-align: center;
            margin-top: 10px;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Login</h1>
    <?php if (isset($error)) { ?>
        <div class="error">
            <?= $error ?>
        </div>
    <?php } ?>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password:</label>
        <input id="password-field" type="password" name="password" required>
        <input type="submit" value="Login">
    </form>
    <a href="../index.php" class="back-link">Go Back to the Website</a>
</div>
</body>
</html>
