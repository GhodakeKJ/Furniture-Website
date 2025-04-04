<?php
include("db.php");
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Online Furniture Management System | Login/Signup Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        ol {
            padding: 10px 0;
        }

        ol li {
            display: inline;
            font-size: 16px;
        }

        ol li.active {
            font-weight: bold;
            color: #333;
        }

        ol li a {
            text-decoration: none;
            color: #000;
            padding-right: 10px;
        }

        .registration {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .registration_left {
            width: 48%;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }

        h2 span {
            font-weight: normal;
            color: #666;
        }

        .registration_form label {
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .registration_form input[type="text"],
        .registration_form input[type="email"],
        .registration_form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .registration_form input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .registration_form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .forget a {
            display: block;
            text-align: right;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .forget a:hover {
            color: #0056b3;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        footer {
            margin-top: 30px;
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>

<!-- Header -->
<?php include_once('header.php');?>

<!-- Main Content -->
<div class="container">
    <ol>
        <li><a href="index.php">Home</a></li>
        <li class="active">Account</li>
    </ol>

    <div class="registration">
        <div class="registration_left">
            <h2>New user? <span>Create an account</span></h2>
            <div class="registration_form">
                <!-- Signup Form -->
                <form id="signup" name="signup" action="" method="post" onsubmit="return checkpass();">
                    <label for="fname">Full Name</label>
                    <input type="text" name="fname" required autofocus>
                    
                    <label for="email">Email Address</label>
                    <input type="email" name="email" required>
                    
                    <label for="mobno">Mobile Number</label>
                    <input type="text" name="mobno" required maxlength="10" pattern="[0-9]+">
                    
                    <label for="password">Password</label>
                    <input type="password" name="password" required id="password">
                    
                    <label for="repeatpassword">Retype Password</label>
                    <input type="password" name="repeatpassword" required id="repeatpassword">
                    
                    <input type="submit" value="Create an Account" name="submit">
                </form>
                <!-- /Signup Form -->
            </div>
        </div>

        <div class="registration_left">
            <h2>Existing user</h2>
            <div class="registration_form">
                <!-- Login Form -->
                <form id="registration_form" action="" name="login" method="post">
                    <label for="email">Email</label>
                    <input type="email" name="email" required>

                    <label for="password">Password</label>
                    <input type="password" name="password" required>

                    <input type="submit" value="Sign In" name="login">
                    <div class="forget">
                        <a href="forgot-password.php">Forgot your password?</a>
                    </div>
                </form>
                <!-- /Login Form -->
            </div>
        </div>

        <div class="clearfix"></div>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2025 Online Furniture Management System</p>
</footer>

</body>
</html>
