<?php include("server.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>About Us</title>
    <link rel="icon" type="image/x-icon" href="img/ourlogo.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="ind.css">
    <script src="https://kit.fontawesome.com/116587da6.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: whitesmoke;
            font-family: 'Poppins';
            font-size: 120%;
            overflow-y: auto;
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

        .logo img{
            position: absolute;
            margin-top: 5px; 
            margin-left: 10px;
        }

        footer {
            background: #343434;
            padding: 20px;
            margin-top: 0;
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

        h3 {
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
            position: absolute;
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

        /* Added CSS for the content positioning */
        .row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
        }

        .imgWrapper img {
            max-width: 500px; /* Adjust as needed */
            height: 500px;
            border-radius: 10px;
        }

        .contentWrapper {
            flex: 1;
            padding: 20px;
        }

        .content {
            text-align: justify;
        }
        #btr {
            display: inline-block;
            background-color: #f18930;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-top: 20px;
            font-weight: bold; /* Make the text bold */
        }

        #btr:hover {
            background-color: #e07222;
        }
        p, i{
            margin-right: 10px;
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

<div class="row">
    <div class="imgWrapper">
        <img src="img/search.jpg" alt="">
    </div>
    <div class="contentWrapper">
        <div class="content">
            <span class="textWrapper">
                <span style="font-size: 50px;">ABOUT US</span>
            </span>
            <h2>WELCOME TO EMPLOY HUB</h2>
            <p>EmployHub is a leading platform dedicated to connecting job seekers with employers across various industries. Our mission is to simplify the job search process by providing a user-friendly interface where individuals can easily browse through a wide range of job opportunities.</p>

            <p>At EmployHub, we understand the importance of finding the right job that matches your skills and aspirations. That's why we strive to offer a comprehensive database of job listings, ranging from entry-level positions to executive roles, catering to diverse backgrounds and experiences.</p>

            <p>With our advanced search filters and personalized recommendations, we aim to streamline the job hunting experience, empowering candidates to discover exciting career opportunities tailored to their preferences.</p>

            <p>In addition to helping job seekers find their dream jobs, EmployHub also partners with employers to assist them in recruiting top talent. Through our innovative platform, employers can create compelling job postings, reach a vast pool of qualified candidates, and efficiently manage the hiring process.</p>

            <p>Whether you're a job seeker looking to take the next step in your career or an employer seeking exceptional talent, EmployHub is here to support you every step of the way. Join us today and let's embark on this journey together towards a brighter future.</p>

            <div id="btr"><a href="alljobs.php">Find Job now</a></div>
            </div>
        </div>
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
