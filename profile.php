
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ofsmsuid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $uid = $_SESSION['ofsmsuid'];
        $AName = $_POST['fname'];
        $mobno = $_POST['mobno'];
        $email = $_POST['email'];

        $sql = "update tbluser set FullName=:name,MobileNumber=:mobilenumber where ID=:uid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $AName, PDO::PARAM_STR);
        $query->bindParam(':mobilenumber', $mobno, PDO::PARAM_STR);
        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
        $query->execute();

        echo '<script>alert("Profile has been updated")</script>';
    }
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Online Furniture Management System | Profile</title>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            width: 70%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .breadcrumb {
            padding: 10px 0;
            background: none;
            font-size: 14px;
        }
        .breadcrumb li {
            display: inline;
            color: #555;
        }
        .breadcrumb li.active {
            font-weight: bold;
        }
        .registration {
            margin-top: 20px;
        }
        h2 {
            font-size: 24px;
            color: #333;
        }
        .registration_form {
            padding: 20px;
        }
        .registration_form input[type="text"],
        .registration_form input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .registration_form input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .registration_form input[type="submit"]:hover {
            background-color: #0056b3;
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
    <?php include_once('includes/header.php');?>

    <!-- Main Content -->
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active">Account</li>
        </ol>
        <div class="registration">
            <h2>View Your Profile</h2>
            <div class="registration_form">
                <!-- Form -->
                <form action="" method="post">
                    <?php
                    $uid = $_SESSION['ofsmsuid'];
                    $sql = "SELECT * from tbluser where ID=:uid";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    if ($query->rowCount() > 0) {
                        foreach ($results as $row) {
                    ?>
                        <div>
                            <label for="fname"><strong>Full Name:</strong></label>
                            <input value="<?php echo $row->FullName; ?>" name="fname" type="text" required>
                        </div>
                        <div>
                            <label for="mobno"><strong>Mobile Number:</strong></label>
                            <input type="text" name="mobno" required maxlength="10" pattern="[0-9]+" value="<?php echo $row->MobileNumber; ?>">
                        </div>
                        <div>
                            <label for="email"><strong>Email Address:</strong></label>
                            <input type="email" name="email" required readonly value="<?php echo $row->Email; ?>">
                        </div>
                        <div>
                            <label for="regdate"><strong>Registration Date:</strong></label>
                            <input type="text" readonly value="<?php echo $row->RegDate; ?>">
                        </div>
                        <div>
                            <input type="submit" value="Update" name="submit">
                        </div>
                    <?php }} ?>
                </form>
                <!-- /Form -->
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Online Furniture Management System</p>
    </footer>
</body>
</html>
<?php } ?>
