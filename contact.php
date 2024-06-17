<?php include("server.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="img/ourlogo.png">
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-image: url(img/contact.jpg);
            background-size: cover;
            font-size: 120%;
            margin: 0;
            padding: 0;
            overflow-y: auto;
            height: 90vh;
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
            margin-top: 0%;
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
        .container{
            width: 100%;
            height: 120vh;

            display: flex;
            align-items: center;
            justify-content: center;
        }
        form{
            background: #fff;
            display: flex;
            flex-direction: column;
            padding: 2vw 4vw;
            width: 90%;
            max-width: 600px;
            border-radius: 10px;            
        }
        form h3{
            color: #555;
            font-weight: 800;
            margin-bottom: 20px;
        }
        form input, form textarea{
            border: 0;
            margin: 10px 0;
            padding: 10px;
            outline: none;
            background: #f5f5f5;
            font-size: 16px;
        }
        form button{
            padding: 15px;
            background: #ff5361;
            color: #fff;
            font-size: 18px;
            border: 0;
            outline: none;
            cursor: pointer;
            width: 150px;
            margin: 20px auto;
            border-radius: 30px;
        }
        p, i{
            margin-right: 10px;
        }  
    </style>
    
</head>
<body>

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
    <div class="container">
        <form id="myForm" action="#">
            <h3>GET IN TOUCH</h3>
            <input type="text" id="name" placeholder="Your Name" autocomplete="off" required>
            <input type="email" id="email" placeholder="Email Address" autocomplete="off" required>
            <input type="text" id="phone" placeholder="Phone no." autocomplete="off" required>
            <input type="text" id="subject" placeholder="Subject" autocomplete="off" required>
            <textarea id="message" rows="4" placeholder="How can we help you?" autocomplete="off" required></textarea>
            <button type="submit">Send</button>
        </form>
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
    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    
    <script src="script.js"></script>

</body>
</html>
