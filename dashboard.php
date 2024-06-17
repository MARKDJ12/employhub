<?php
// Include database configuration file
include '../config.php'; 

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: panel.php'); 
    exit();
}

// Fetch the count of job listings
$jobCountQuery = "SELECT COUNT(*) AS total_jobs FROM jobs";
$jobCountResult = $conn->query($jobCountQuery);
$jobCountRow = $jobCountResult->fetch_assoc();
$totalJobs = $jobCountRow['total_jobs'];

// Fetch the count of unique companies
$companyCountQuery = "SELECT COUNT(DISTINCT company_name) AS total_companies FROM jobs";
$companyCountResult = $conn->query($companyCountQuery);
$companyCountRow = $companyCountResult->fetch_assoc();
$totalCompanies = $companyCountRow['total_companies'];

// Fetch the count of registered users
$userCountQuery = "SELECT COUNT(*) AS total_users FROM users";
$userCountResult = $conn->query($userCountQuery);
$userCountRow = $userCountResult->fetch_assoc();
$totalUsers = $userCountRow['total_users'];

// Fetch the count of applicants
$applicantCountQuery = "SELECT COUNT(*) AS total_applicants FROM applicants";
$applicantCountResult = $conn->query($applicantCountQuery);
$applicantCountRow = $applicantCountResult->fetch_assoc();
$totalApplicants = $applicantCountRow['total_applicants'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Dashboard</title>
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
        .stats-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .stat-box {
            flex: 1;
            background: linear-gradient(145deg, #fff, #ece9e6);
            border-left: 5px solid #3498db;
            border-radius: 8px;
            padding: 20px;
            margin: 10px;
            box-shadow: 5px 5px 15px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }
        .stat-box h2 {
            margin: 0;
            font-size: 20px;
            color: #2C3E50;
        }
        .stat-box p {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
            color: #34495E;
        }
        .stat-icon {
            font-size: 30px;
        }
        .details-link {
            position: absolute;
            bottom: 10px;
            right: 10px;
            font-size: 14px;
            text-decoration: none;
            color: #3498db;
        }
        .details-link:hover {
            text-decoration: underline;
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
        <h1>DASHBOARD</h1>
        <div class="stats-container">
            <div class="stat-box" style="border-left-color: #3498db;">
                <div>
                    <h2>Job Listings</h2>
                    <p><?= $totalJobs ?></p>
                </div>
                <i class="fas fa-briefcase stat-icon" style="color: #3498db;"></i>
                <a href="job_listings.php" class="details-link">View Full Details</a>
            </div>
            <div class="stat-box" style="border-left-color: #e74c3c;">
                <div>
                    <h2>Companies</h2>
                    <p><?= $totalCompanies ?></p>
                </div>
                <i class="fas fa-building stat-icon" style="color: #e74c3c;"></i>
                <a href="companies.php" class="details-link">View Full Details</a>
            </div>
            <div class="stat-box" style="border-left-color: #2ecc71;">
                <div>
                                        <h2>Registered Users</h2>
                    <p><?= $totalUsers ?></p>
                </div>
                <i class="fas fa-users stat-icon" style="color: #2ecc71;"></i>
                <a href="reg_users.php" class="details-link">View Full Details</a>
            </div>
            <div class="stat-box" style="border-left-color: #f39c12;">
                <div>
                    <h2>Applicants</h2>
                    <p><?= $totalApplicants ?></p>
                </div>
                <i class="fas fa-user-plus stat-icon" style="color: #f39c12;"></i>
                <a href="applicants.php" class="details-link">View Full Details</a>
            </div>
        </div>
    </div>
</body>
</html>

