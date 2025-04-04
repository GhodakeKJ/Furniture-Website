
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ofsmsuid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $uid = $_SESSION['ofsmsuid'];
        $cpassword = md5($_POST['currentpassword']);
        $newpassword = md5($_POST['newpassword']);

        // Check if the current password is correct
        $sql = "SELECT ID FROM tbluser WHERE ID = :uid AND Password = :cpassword";
        $query = $dbh->prepare($sql);
        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
        $query->bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            // Update the password
            $con = "UPDATE tbluser SET Password = :newpassword WHERE ID = :uid";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':uid', $uid, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();

            echo '<script>alert("Your password has been successfully changed.");</script>';
        } else {
            echo '<script>alert("Your current password is incorrect.");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password | Online Furniture Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .breadcrumb {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .breadcrumb a {
            color: #007bff;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .registration_form {
            max-width: 500px;
            margin: 0 auto;
        }
        .registration_form div {
            margin-bottom: 15px;
        }
        .registration_form strong {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .registration_form input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .registration_form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .registration_form input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .clearfix {
            clear: both;
        }
    </style>
    <script>
        function checkpass() {
            var newPassword = document.forms["changepassword"]["newpassword"].value;
            var confirmPassword = document.forms["changepassword"]["confirmpassword"].value;
            if (newPassword !== confirmPassword) {
                alert("New Password and Confirm Password do not match!");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active">Account</li>
        </ol>
        <h2>Change Password</h2>
        <div class="registration_form">
            <form action="" method="post" onsubmit="return checkpass();" name="changepassword">
                <div>
                    <strong>Current Password:</strong>
                    <input type="password" name="currentpassword" required>
                </div>
                <div>
                    <strong>New Password:</strong>
                    <input type="password" name="newpassword" required>
                </div>
                <div>
                    <strong>Confirm Password:</strong>
                    <input type="password" name="confirmpassword" required>
                </div>
                <div>
                    <input type="submit" value="Change" name="submit">
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php include_once('includes/footer.php'); ?>
</body>
</html>
<?php } ?>