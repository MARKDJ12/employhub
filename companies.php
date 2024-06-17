
<?php
include '../config.php'; 

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: panel.php'); 
    exit();
}

// Handle Search
$searchTerm = $_GET['search'] ?? '';
$query = "SELECT company_name FROM jobs WHERE (job_title LIKE ? OR company_name LIKE ?) ORDER BY job_id";
$stmt = $conn->prepare($query);
$searchParam = '%' . $searchTerm . '%';
$stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

$companies = []; // Array to hold unique companies
$counter = 1; // Initialize a counter variable for ID
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Companies</title>
    <link rel="icon" type="image/x-icon" href="../img/ourlogo.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
         body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f4f4;
            color: #333;
        }
        .headed {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #2C3E50;
            color: #fff;
            padding: 1px;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #34495E;
            color: #fff;
            padding-top: 80px;
            overflow-y: auto;
            z-index: 999;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        .navbar li {
            padding: 15px 20px;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: background 0.3s ease;
        }
        .navbar a:hover {
            background-color: #4E5F70;
        }
                .navbar a i {
            margin-right: 10px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            padding-top: 80px;
            min-height: 100vh;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: #ffffff;
        }
        .search-bar {
            position: absolute;
            right: 20px; /* Adjusted positioning */
            top: 125px;
            display: flex;
            align-items: center;
            background-color: #fff;
            border-radius: 5px;
            padding: 5px 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .search-bar input {
            border: none;
            outline: none;
            padding: 5px;
            width: 200px;

        }
        .search-bar button {
            background: none;
            border: none;
            color: #3498db;
            cursor: pointer;
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
            <form action="companies.php" method="GET">
                <input type="text" name="search" placeholder="Search Company..." value="<?= htmlspecialchars($searchTerm) ?>">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <h1>COMPANIES</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Company Name</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($row = $result->fetch_assoc()):
                    $companyKey = strtolower($row['company_name']); // Normalize to lowercase
                    if (!isset($companies[$companyKey])) { // Check if already added
                        $companies[$companyKey] = true; // Mark as added
                ?>
                <tr>
                    <td><?= $counter++ ?></td> <!-- Increment and display counter as ID -->
                    <td><?= htmlspecialchars($row['company_name']) ?></td>
                </tr>
                <?php
                    }
                endwhile;
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>
