
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ofsmsuid']) == 0) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Online Furniture Management System | Order Page</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
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
        }
        .breadcrumb {
            padding: 10px;
            background-color: #eee;
            margin-bottom: 20px;
        }
        .breadcrumb a {
            text-decoration: none;
            color: #333;
        }
        .cart-items {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .cart-header {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .cart-sec {
            display: flex;
            align-items: center;
        }
        .cart-item {
            flex: 1;
        }
        .cart-item img {
            max-width: 100px;
            height: auto;
        }
        .cart-item-info {
            flex: 3;
            padding-left: 20px;
        }
        .cart-item-info h3 {
            margin: 0;
            font-size: 18px;
        }
        .cart-item-info p {
            margin: 5px 0;
        }
        .delivery {
            flex: 1;
            text-align: right;
        }
        .delivery a {
            text-decoration: none;
            color: #333;
            margin-left: 10px;
        }
        .delivery a:hover {
            color: #007bff;
        }
        .clearfix {
            clear: both;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include_once('includes/header.php'); ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="men.html">Home</a></li>
            <li class="active">My Order</li>
        </ol>
        <div class="cart-items">
            <h2>Your Order Detail</h2>
            <?php
            $userid = $_SESSION['ofsmsuid'];
            $sql = "SELECT * FROM tblorder WHERE UserID = :userid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':userid', $userid, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $cnt = 1;
            if ($query->rowCount() > 0) {
                foreach ($results as $row) {
            ?>
            <div class="cart-header">
                <div class="cart-sec">
                    <div class="cart-item">
                        <img src="images/images (2).jpg" alt="Furniture Image" />
                    </div>
                    <div class="cart-item-info">
                        <h3>Order #<?php echo $row->OrderNumber; ?><span>Order Date: <?php echo $row->OrderDate; ?></span></h3>
                        <p style="padding-top: 20px">Order Status: <?php
                            $status = $row->Status;
                            if ($status == '') {
                                echo "Waiting for confirmation";
                            } else {
                                echo $status;
                            }
                        ?></p>
                    </div>
                    <div class="delivery">
                        <a href="javascript:void(0);" onclick="window.open('trackorder.php?odid=<?php echo htmlentities($row->OrderNumber); ?>', 'popUpWin', 'width=600,height=600,left=100,top=100');" title="Track order"><strong style="color: red">Track Order</strong></a>
                        <a href="order-detail.php?orderid=<?php echo $row->OrderNumber; ?>" class="btn theme-btn-dash"><strong style="color: blue">View Details</strong></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <?php
                $cnt = $cnt + 1;
                }
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>
</body>
</html>
<?php } ?>