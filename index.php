<?php include("server.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="icon" type="image/x-icon" href="img/ourlogo.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="ind.css">
</head>
<style>
    body::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: -2%;
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent black overlay */
    z-index: -1;
}
</style>
<body>
    <div class="wrapper">
        <div class="headers">
            <div class="logo">
            <a href="index.php"><img src="img/logo.png" width="150" height="45"></a>
            </div>
            <nav>
                <ul class="navbar">
                    <li><strong><a href="index.php">Home</a></strong></li>
                    <li><strong><a href="about.php">About Us</a></strong></li>
                    <li><strong><a href="alljobs.php">All Jobs</a></strong></li>
                    <li><strong><a href="contact.php">Contact Us</a></strong></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="dropdown">
                            <strong><a href="#" class="dropbtn">Account</a></strong>
                            <div class="dropdown-content">
                                <strong><a href="profile.php">Profile</a></strong>
                                <strong><a href="logout.php">Logout</a></strong>
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
        <div class="main-content">
            <h2>Welcome to Our Website</h2>
            <p>EmployHub is a leading platform dedicated to connecting job seekers with employers across various industries... <a href="about.php"><strong style="color: blue;">Read more</strong></a></p>
        </div>
    </div>
    <footer>
        <div class="contain">
            <div class="footer-content">
                <h3 style="color: white;">Contact Us</h3>
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
                    <li><a href="Admin/panel.php">Admin Login</a></li>
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
