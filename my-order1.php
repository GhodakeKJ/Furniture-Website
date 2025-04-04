
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ofsmsuid']) == 0) {
    header('location:logout.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furnyish Store - My Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .breadcrumb {
            padding: 10px 0;
            font-size: 14px;
            color: #666;
        }
        .breadcrumb a {
            color: #666;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .cart-items {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .cart-items h2 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }
        .cart-header {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }
        .cart-sec {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
        .cart-item-info h3 {
            margin: 0;
            font-size: 18px;
        }
        .cart-item-info h3 span {
            display: block;
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        .cart-item-info p {
            margin: 10px 0;
            font-size: 14px;
            color: #666;
        }
        .delivery {
            margin-left: auto;
            display: flex;
            gap: 10px;
        }
        .delivery a {
            color: #fff;
            background-color: #007bff;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }
        .delivery a:hover {
            background-color: #0056b3;
        }
        .clearfix {
            clear: both;
        }
        footer {
            text-align: center;
            padding: 20px;
            background: #333;
            color: #fff;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="men.html">Home</a> &gt; My Order
        </div>

        <!-- Cart Items -->
        <div class="cart-items">
            <h2>Your Order Detail</h2>
            <?php
            $userid = $_SESSION['ofsmsuid'];
            $sql = "SELECT * FROM tblorder WHERE UserID = :userid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':userid', $userid, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() > 0) {
                foreach ($results as $row) {
            ?>
            <div class="cart-header">
                <div class="cart-sec">
                    <div class="cart-item">
                        <img src="images/images (2).jpg" alt="Product Image">
                    </div>
                    <div class="cart-item-info">
                        <h3>Order #<?php echo htmlentities($row->OrderNumber); ?><span>Order Date: <?php echo htmlentities($row->OrderDate); ?></span></h3>
                        <p>Order Status: <?php echo ($row->Status == '') ? 'Waiting for confirmation' : htmlentities($row->Status); ?></p>
                    </div>
                    <div class="delivery">
                        <a href="javascript:void(0);" onclick="window.open('trackorder.php?oid=<?php echo htmlentities($row->OrderNumber); ?>', 'popUpWin', 'width=600,height=600,left=100,top=100');">Track Order</a>
                        <a href="order-detail.php?orderid=<?php echo htmlentities($row->OrderNumber); ?>">View Details</a>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p>No orders found.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Furnyish Store. All rights reserved.</p>
    </footer>
</body>
</html>
<?php  ?>