<?php
include("config.php");  // Ensure config.php is correctly included for the database connection

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$searchTerm = $_GET['search'] ?? '';
$searchSql = $searchTerm ? " WHERE (job_title LIKE ? OR company_name LIKE ?) AND published = 1" : " WHERE published = 1";
$sql = "SELECT * FROM jobs" . $searchSql . " ORDER BY closing_date DESC";

$stmt = $conn->prepare($sql);
if ($searchTerm) {
    $likeTerm = '%' . $searchTerm . '%';
    $stmt->bind_param("ss", $likeTerm, $likeTerm);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Jobs</title>
    <link rel="icon" type="image/x-icon" href="img/ourlogo.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="ind.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-image: url(img/lef.jpg);
            font-size: 120%;
            margin: 0;
            padding: 0;
            overflow-y: auto;
            height: 100vh;
            display: flex;
            flex-direction: column; 
        }
        .navbar {
            background-color: #0009;
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .navbar li {
            display: inline-block;
            margin-right: 5px;
        }
        .navbar li a {
            display: block;
            padding: 15px 20px;
            text-decoration: none;
            color: white;
        }
        .navbar li a:hover {
            background: #B0C4DE;
            border-radius: 5px;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #0009;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 5px;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: none;
            border-radius: 5px;
        }
        .header {
            width: 100%;
            border-radius: 10px 10px 0px 0px;
            padding: 0px;
            font-family: verdana;
        }
        .header nav {
            margin-top: 0px;
        }
        .logo img {
            position: absolute;
            margin-top: 5px;
            margin-left: 10px;
        }
        .content {
            width: 100%;
            margin-top: 25px;
            margin-bottom: 5%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        form {
            background: #fff;
            display: flex;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 5px;
            overflow: hidden;
        }
        form input {
            flex: 1;
            padding: 10px;
            border: none;
            font-size: 16px;
        }
        form button {
            padding: 10px 20px;
            background-color: tomato;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        @media (max-width: 600px) {
            form {
                flex-direction: column;
                width: 80%;
            }
            form input, form button {
                width: 100%;
            }
        }
        .job-listings {
            width: 80%;
            margin: auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .job {
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 15px;
            width: calc(33% - 30px);
            border-radius: 8px;
            transition: transform 0.3s ease;
        }
        .job:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .job h3, .job p {
            margin-bottom: 10px;
        }
        .job a {
            display: inline-block;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        footer {
            background: #343434;
            padding: 5px;
            margin-top: 20px;
        }
        .contain {
            width: 1140px;
            margin: auto;
            display: flex;
            justify-content: center;
        }
        .footer-content {
            width: 33.3%;
        }
        .footer-content h3 {
            font-size: 28px;
            margin-bottom: 15px;
            text-align: center;
            color: white;
        }
        .footer-content p {
            width: 190px;
            margin: auto;
            padding: 7px;
            color: white;
        }
        .footer-content ul {
            text-align: center;
            padding: 0;
        }
        .list li {
            width: auto;
            text-align: center;
            list-style: none;
            padding: 7px;
            position: relative;
        }
        .list li::before {
            content: '';
            position:absolute;
            transform: translate(-50%,-50%);
            left: 50%;
            top: 100%;
            width: 0;
            height: 2px;
            background: #f18930;
            transition-duration: .5s;
        }
        .list li:hover::before {
            width: 70px;
        }
        a {
            text-decoration: none;
            color: white;
        }
        a:hover {
            color: #f18930;
        }
        .bottom-bar {
            background: #f18930;
            text-align: center;
            padding: 10px 0;
            margin-top: 0;
        }
        .bottom-bar p {
            color: #343434;
            margin: 0;
            font-size: 16px;
            margin: 7px;
        }
        p, i{
            margin-right: 10px;
        } 
        .no{
            margin-bottom: 30%;
        } 
        .wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
<div class="wrapper">
<div class="logo">
    <a href="index.php"><img src="img/logo.png" width="150" height="45"></a>
</div>
<div class="header">
    <nav>
        <ul class="navbar">
            <li><strong><a href="index.php">Home</a></strong></li>
            <li><strong><a href="about.php">About Us</a></strong></li>
            <li><strong><a href="alljobs.php">All Jobs</a></strong></li>
            <li><strong><a href="contact.php">Contact Us</a></strong></li>
            <?php if (isset($_SESSION['username'])): ?>
                <li class="dropdown">
                    <a href="#" class="dropbtn"><strong>Account</strong></a>
                    <div class="dropdown-content">
                        <a href="profile.php"><strong>Profile</strong></a>
                        <a href="logout.php"><strong>Logout</strong></a>
                    </div>
                </li>
                <li><strong><a href="postjob.php">Post Job</a></strong></li>
            <?php else: ?>
                <li><strong><a href="login.php">Login</a></strong></li>
                <li><strong><a href="register.php">Register</a></strong></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
<h2 style="text-align: center; color: white;">All Jobs</h2>
<div class="content">
    <form method="GET">
        <input type="text" name="search" placeholder="Search for jobs" value="<?= htmlspecialchars($searchTerm) ?>">
        <button type="submit">Search</button>
    </form>
</div>
<?php if ($result->num_rows > 0): ?>
    <div class="job-listings">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="job">
                <h3><?= htmlspecialchars($row['job_title']) ?></h3>
                <p><strong>Company Name:</strong> <?= htmlspecialchars($row['company_name']) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($row['city'] . ', ' . $row['country']) ?></p>
                <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['job_description'])) ?></p>
                <a href="job_details.php?id=<?= $row['job_id'] ?>">View Full Details</a>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <div class="no">
    <p style="color: ghostwhite; text-align: center;">No jobs found.</p>
    </div>
</div>
<?php endif; ?>
<footer>
    <div class="contain">
        <div class="footer-content">
            <h3>Contact Us</h3>
            <p><i class="fas fa-envelope"></i> Email: employhub96@gmail.com</p>
            <p><i class="fas fa-phone"></i> Phone: 09856280917</p>
            <p><i class="fas fa-map-marker-alt"></i> Address: Claveria, Misamis Oriental</p>
        </div>
        <div class="footer-content">
            <h3>Quick Links</h3>
            <ul class="list">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="alljobs.php">All Jobs</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </div>
</footer>
<div class="bottom-bar">
    <p>&copy; 2024 EmployHub. All rights are reserved.</p>
    <p>Disclaimer: This Website is For Educational Purposes Only</p>

</div>

</body>
</html>
<?php $conn->close(); ?>
