<?php 
include("server.php");  

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = ?";
if ($stmt = $db->prepare($query)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        session_unset();
        session_destroy();
        header('Location: login.php');
        exit;
    }
    $stmt->close();
} else {
    echo "<script>alert('Error accessing database');</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $new_password = mysqli_real_escape_string($db, $_POST['password']);
    $hashed_password = !empty($new_password) ? password_hash($new_password, PASSWORD_DEFAULT) : $user['password'];
    $full_name = mysqli_real_escape_string($db, $_POST['full_name']);
    $address = mysqli_real_escape_string($db, $_POST['Address']);
    $phone_number = mysqli_real_escape_string($db, $_POST['phone_number']);
    $educational_background = mysqli_real_escape_string($db, $_POST['educational_background']);
    $skills = mysqli_real_escape_string($db, $_POST['Skills']);
    $experience = mysqli_real_escape_string($db, $_POST['Experience']);
    $user_picture = $user['user_picture']; // Default to existing picture

if (isset($_FILES['user_picture']) && $_FILES['user_picture']['error'] == 0) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];  // Allowed file types
    $filename = $_FILES['user_picture']['name'];
    $filetmp = $_FILES['user_picture']['tmp_name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    if (in_array($ext, $allowed)) {
        // Create a unique file name to prevent file overwriting
        $newFilename = "uploads/" . $username . "_" . time() . "." . $ext;

        // Check if uploads directory exists, if not create it
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);  // Create directory if it does not exist with full permissions
        }

        // Attempt to move the uploaded file to the new path
        if (move_uploaded_file($filetmp, $newFilename)) {
            $user_picture = $newFilename;
        } else {
            echo "<script>alert('Failed to move uploaded file.');</script>";
            $user_picture = $user['user_picture']; // Fallback to old picture if upload fails
        }
    } else {
        echo "<script>alert('Invalid file type.');</script>";
        $user_picture = $user['user_picture']; // Fallback to old picture if invalid type
    }
} else {
    $user_picture = $user['user_picture']; // Fallback to old picture if no file was uploaded
    }

    // Update database
    $updateQuery = "UPDATE users SET email = ?, password = ?, full_name = ?, Address = ?, phone_number = ?, educational_background = ?, Skills = ?, Experience = ?, user_picture = ? WHERE username = ?";
    if ($updateStmt = $db->prepare($updateQuery)) {
        $updateStmt->bind_param("ssssssssss", $email, $hashed_password, $full_name, $address, $phone_number, $educational_background, $skills, $experience, $user_picture, $username);

        $updateStmt->execute();
        $updateStmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="img/ourlogo.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E6E6FA;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            background: #F2F0DF;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .profile-icon {
            width: 120px; 
            height: 120px;
            border-radius: 50%;
            background: url('<?php echo htmlspecialchars($user['user_picture']); ?>') no-repeat center center;
            background-size: cover;
            margin: 0 auto;
            border: 3px solid #0056b3; 
        }
        .username {
            font-size: 20px; 
            color: #333;
            margin-top: 20px; 
        }
        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .form-group {
            flex: 1 1 48%; 
            padding: 10px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #444; 
            font-size: 16px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group .fa { 
            margin-right: 5px;
            color: darkblue; 
        }
        button {
            padding: 12px 20px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 18px; 
        }
        button:hover {
            background-color: #004494;
        }
        .back-button {
            background-color: #6c757d;  /* Different color for distinction */
            margin-right: 85%; /* Aligns the button to the left */
        }       
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-icon"></div>
        <div class="username"><?php echo htmlspecialchars($user['full_name']); ?></div>
        <form method="POST" action="" enctype="multipart/form-data">
        <button type="button" class="back-button" onclick="history.back();"><i class="fa fa-arrow-left"></i> Back</button>            
            <div class="form-group">
                <label for="email"><i class="fa fa-envelope"></i>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password"><i class="fa fa-lock"></i>Create New Password (optional):</label>
                <input type="password" name="password">
            </div>
            <div class="form-group">
                <label for="full_name"><i class="fa fa-user"></i>Full Name:</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="Address"><i class="fa fa-home"></i>Address:</label>
                <input type="text" name="Address" value="<?php echo htmlspecialchars($user['Address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_number"><i class="fa fa-phone"></i>Phone Number:</label>
                <input type="text" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
            </div>
            <div class="form-group">
                <label for="educational_background"><i class="fa fa-graduation-cap"></i>Educational Background:</label>
                <textarea name="educational_background" required><?php echo htmlspecialchars($user['educational_background']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="Skills"><i class="fa fa-lightbulb"></i>Skills:</label>
                <textarea name="Skills" required><?php echo htmlspecialchars($user['Skills']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="Experience"><i class="fa fa-briefcase"></i>Experience:</label>
                <textarea name="Experience" required><?php echo htmlspecialchars($user['Experience']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="user_picture"><i class="fa fa-camera"></i>Profile Picture:</label>
                <input type="file" name="user_picture">
            </div>
            <button type="submit"><i class="fa fa-upload"></i> Update Profile</button>
        </form>
    </div>
</body>
</html>
