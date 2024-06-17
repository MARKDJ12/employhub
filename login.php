<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link rel="icon" type="image/x-icon" href="img/ourlogo.png">
    <link rel="stylesheet" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<style>
    body {
        background-image: url("img/logback.jpg");
        background-size: cover;
    }
    .header{
        margin-top: 13%;
    }
</style>
<body>
    <div class="header">
        <h2>Login</h2>
    </div>
    <?php if(isset($_SESSION['success'])): ?>
        <div class="success">
            <?php 
            echo $_SESSION['success']; 
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>
    <form method="post" action="login.php">
        <?php include('errors.php'); ?>   
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>
<div class="g-recaptcha" data-sitekey="6LchOO4pAAAAAMY84gENpcvXTq8zrFEBZE4oK3Ec"></div>

        <div class="input-group">
            <button type="submit" name="login" class="btn">Login</button>
        </div>  
        <p>
            Don't have an account? <a href="register.php">Register</a>
        </p>          
    </form>
</body>
</html>
