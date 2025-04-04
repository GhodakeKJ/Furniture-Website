
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $newpassword = md5($_POST['newpassword']);

    // Check if the email and mobile number exist in the database
    $sql = "SELECT Email FROM tbluser WHERE Email = :email AND MobileNumber = :mobile";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        // Update the password
        $con = "UPDATE tbluser SET Password = :newpassword WHERE Email = :email AND MobileNumber = :mobile";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
        $chngpwd1->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();
        echo "<script>alert('Your password has been successfully changed.');</script>";
    } else {
        echo "<script>alert('Email ID or Mobile number is invalid.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | Online Furniture Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .log {
            width: 50%;
            float: left;
        }
        .login-right {
            width: 45%;
            float: right;
            padding-left: 5%;
        }
        .clearfix {
            clear: both;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .acount-btn {
            display: inline-block;
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
        }
        .acount-btn:hover {
            background-color: #218838;
        }
        .breadcrumb {
            padding: 10px 0;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .breadcrumb a {
            color: #007bff;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active">Forgot Password</li>
        </ol>
        <h2>Forgot Password</h2>
        <div class="log">
            <p>Welcome, please reset your password.</p>
            <p>Please fill the following details:</p>
            <form action="" method="post" name="chngpwd" onsubmit="return validateForm()">
                <label>Email:</label>
                <input type="text" name="email" required>
                <label>Mobile Number:</label>
                <input type="text" name="mobile" required maxlength="10" pattern="[0-9]+">
                <label>New Password:</label>
                <input type="password" name="newpassword" required>
                <label>Confirm Password:</label>
                <input type="password" name="confirmpassword" required>
                <input type="submit" value="Reset" name="submit">
            </form>
        </div>
        <div class="login-right">
            <h3>NEW REGISTRATION</h3>
            <p>By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account, and more.</p>
            <a class="acount-btn" href="signup.php">Create an Account</a>
        </div>
        <div class="clearfix"></div>
    </div>

    <script>
        function validateForm() {
            var newPassword = document.forms["chngpwd"]["newpassword"].value;
            var confirmPassword = document.forms["chngpwd"]["confirmpassword"].value;
            if (newPassword !== confirmPassword) {
                alert("New Password and Confirm Password do not match!");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>