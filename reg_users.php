<?php
include '../config.php'; 

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: panel.php'); 
    exit();
}

$searchTerm = $_GET['search'] ?? '';
$query = "SELECT id, user_picture, full_name, email, phone_number, Address, educational_background, Skills, Experience FROM users WHERE full_name LIKE ? OR email LIKE ? ORDER BY full_name";
$stmt = $conn->prepare($query);
$searchParam = '%' . $searchTerm . '%';
$stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $deleteQuery = "DELETE FROM users WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $deleteId);
    $deleteStmt->execute();
    header("Location: reg_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Registered Users</title>
    <link rel="icon" type="image/x-icon" href="../img/ourlogo.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="reg.css">
    <style>
        /* Additional styles for delete icon */
        .delete-icon {
            color: red;
            cursor: pointer;
            background: none;
            border: none;
            font-size: 1.2em;
        }
        .delete-icon:hover {
            color: darkred;
        }
    </style>
</head>
<body>
    <div class="headed">
        <h1>Employhub | Admin Panel</h1>
    </div>
    <div class="navbar">
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="job_listings.php"><i class="fas fa-briefcase"></i> Job Listings</a></li>
            <li><a href="companies.php"><i class="fas fa-building"></i> Companies</a></li>
            <li><a href="reg_users.php"><i class="fas fa-users"></i> Reg Users</a></li>
            <li><a href="applicants.php"><i class="fas fa-user-plus"></i> Applicants</a></li>
            <li><a href="panel.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="search-bar">
            <form action="reg_users.php" method="GET">
                <input type="text" name="search" placeholder="Search User Profiles..." value="<?= htmlspecialchars($searchTerm) ?>">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <h1>REGISTERED USERS</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Profile</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Educational Background</th>
                    <th>Skills</th>
                    <th>Experience</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $defaultPicture = '../uploads'; 
                $counter = 1; 
                while ($row = $result->fetch_assoc()):
                    $userPicture = !empty($row['user_picture']) ? htmlspecialchars($row['user_picture']) : $defaultPicture;
                ?>
                <tr>
                    <td><?= $counter++ ?></td>
                    <td><img src="../<?= $userPicture ?>" alt="Profile Picture" class="profile-picture"></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone_number']) ?></td>
                    <td><?= htmlspecialchars($row['Address']) ?></td>
                    <td><?= htmlspecialchars($row['educational_background']) ?></td>
                    <td><?= htmlspecialchars($row['Skills']) ?></td>
                    <td><?= htmlspecialchars($row['Experience']) ?></td>
                    <td>
                        <form action="reg_users.php" method="POST" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?= htmlspecialchars($row['id']) ?>">
                            <button type="submit" class="delete-icon" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>
