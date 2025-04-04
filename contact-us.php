
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us | Online Furniture Management System</title>
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
        .contact-head {
            margin-bottom: 30px;
        }
        .contact-head h2 {
            text-align: center;
            color: #333;
        }
        .contact-left, .contact-right {
            width: 48%;
            float: left;
            margin-bottom: 20px;
        }
        .contact-right {
            float: right;
        }
        .contact-left strong {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }
        .contact-left p {
            margin: 0 0 15px;
            color: #333;
        }
        .contact-right img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active">Contact</li>
        </ol>
        <div class="contact-head">
            <h2>Get In Touch</h2>
            <?php
            $sql = "SELECT * FROM tblpage WHERE PageType = 'contactus'";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $cnt = 1;
            if ($query->rowCount() > 0) {
                foreach ($results as $row) {
                    ?>
                    <div class="contact-left">
                        <strong>Address:</strong>
                        <p><?php echo $row->PageDescription; ?></p>
                        <strong>Mobile Number:</strong>
                        <p><?php echo $row->MobileNumber; ?></p>
                        <strong>Email:</strong>
                        <p><?php echo $row->Email; ?></p>
                    </div>
                    <div class="contact-right">
                        <img class="img-responsive" src="images/banner3.jpg" alt="about img">
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    $cnt = $cnt + 1;
                }
            }
            ?>
        </div>
    </div>
    <?php include_once('includes/footer.php'); ?>
</body>
</html>