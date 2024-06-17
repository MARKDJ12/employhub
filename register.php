<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>User Registration</title>
        <link rel="icon" type="image/x-icon" href="img/ourlogo.png">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url("img/logback.jpg");
            background-size: cover;
        }

        .p {
            text-decoration: underline;
            align-content: center;
            text-align: center;
            text-size-adjust: 100%;
        }
            }
                }
    .header{
            margin-top: 14%;
    }
    </style>
    <body>
        <div class="header">
            <h2>Register</h2>
        </div>
        <form method="post" action="register.php">
            <?php include('errors.php'); ?>
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="text" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password_1">
            </div>
            <div class="input-group">
                <label>Confirm Password</label>
                <input type="password" name="password_2">
            </div>
            <div class="input-group">
                <div class="g-recaptcha" data-sitekey="6LchOO4pAAAAAMY84gENpcvXTq8zrFEBZE4oK3Ec"></div>
                <button type="submit" name="register" class="btn">Register</button>
            </div>  
            <p>
                Already have an account? <a href="login.php">Sign in</a>
            </p>          
        </form><br><br>
    </body>
</html>
