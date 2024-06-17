<?php
// Include database configuration file
include '../config.php'; 

// Start session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header('Location: panel.php'); 
    exit();
}

// Handle delete request
if (isset($_POST['delete'])) {
    $applicantId = $_POST['applicant_id'];
    $deleteQuery = "DELETE FROM applicants WHERE id = ?";
    $stmtDelete = $conn->prepare($deleteQuery);
    $stmtDelete->bind_param("i", $applicantId);
    $stmtDelete->execute();
    $stmtDelete->close();
}

// Get search term from query string, default to empty string
$searchTerm = $_GET['search'] ?? '';

// SQL query to fetch applicants based on search term
$query = "
    SELECT 
        a.id, 
        a.full_name, 
        a.email, 
        u.phone_number, 
        j.company_name 
    FROM 
        applicants a
    JOIN 
        jobs j 
    ON 
        a.job_id = j.job_id
    JOIN
        users u
    ON
        a.users_id = u.id
    WHERE 
        a.full_name LIKE ? OR a.email LIKE ?
    ORDER BY 
        a.full_name
";

// Prepare the statement
$stmt = $conn->prepare($query);

// Check if statement preparation was successful
if (!$stmt) {
    // Handle error
    echo "Error: " . $conn->error;
    exit();
}

// Bind parameters and execute query
$searchParam = '%' . $searchTerm . '%';
$stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();

// Get result set
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Applicants</title>
    <link rel="icon" type="image/x-icon" href="../img/ourlogo.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="app.css">

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
            <form action="applicants.php" method="GET">
                <input type="text" name="search" placeholder="Search Applicants..." value="<?= htmlspecialchars($searchTerm) ?>">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <h1>APPLICANTS</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Applied Company</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $id = 1; // Initialize counter
                while ($row = $result->fetch_assoc()): 
                ?>
                    <tr>
                        <td><?= $id ?></td>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone_number']) ?></td>
                        <td><?= htmlspecialchars($row['company_name']) ?></td>
                        <td>
                            <form method="POST" action="applicants.php" onsubmit="return confirm('Are you sure you want to delete this applicant?');">
                                <input type="hidden" name="applicant_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="delete" class="delete-btn"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php 
                    $id++; // Increment counter
                endwhile; 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php 
// Close statement and database connection
$stmt->close();
$conn->close(); 
?>
