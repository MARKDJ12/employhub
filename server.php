<?php
session_start();
$username = "";
$email = "";
$errors = array();

// Establish database connection
$db = mysqli_connect('localhost', 'root', '', 'employhub');

// Check if the connection is successful
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Your Google reCAPTCHA secret key
$secret = '6LchOO4pAAAAADZ782xuKNKiWmHUlV5g50QGF4_d';

// Function to verify reCAPTCHA
function verifyRecaptcha($token, $secret) {
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secret,
        'response' => $token
    ];
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $result = json_decode($response, true);

    // Log the response for debugging
    error_log(print_r($result, true));

    return $result;
}

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    $recaptchaResponse = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';

    // Ensure all fields are filled
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match!");
    }
    if (empty($recaptchaResponse)) {
        array_push($errors, "reCAPTCHA verification failed");
    } else {
        $recaptcha = verifyRecaptcha($recaptchaResponse, $secret);
        if (!$recaptcha['success']) {
            array_push($errors, "reCAPTCHA verification failed");
        }
    }

    // Check if username or email already exists
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // If user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // Hash password before saving to database
    $password = password_hash($password_1, PASSWORD_DEFAULT);

    // If there are no errors, save user to database
    if (count($errors) == 0) {
        $query = "INSERT INTO users (username, email, password) VALUES('$username', '$email', '$password')";
        mysqli_query($db, $query);
        array_push($errors, "New Account has been created successfully");
    }
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $recaptchaResponse = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';

    if (empty($username)) {
        array_push($errors, "Username is required");
    }        
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    if (empty($recaptchaResponse)) {
        array_push($errors, "reCAPTCHA verification failed");
    } else {
        $recaptcha = verifyRecaptcha($recaptchaResponse, $secret);
        if (!$recaptcha['success']) {
            array_push($errors, "reCAPTCHA verification failed");
        }
    }

    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                header('location: index.php');                    
            } else {
                array_push($errors, "The password is incorrect");
            }
        } else {
            array_push($errors, "Username not found");
        }
    }
}
?>
