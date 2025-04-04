<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ofsmsuid']) == 0) {
    header('location:logout.php');
} else {
    if (!empty($_GET["action"])) {
        switch ($_GET["action"]) {
            // Code for emptying the cart
            case "empty":
                unset($_SESSION["cart_item"]);
                unset($_SESSION['tprice']);
                header('location:cart.php');
                break;
        }
    }

    if (isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $cnumber = $_POST['cnumber'];
        $fnaobno = $_POST['flatbldgnumber'];
        $street = $_POST['streename'];
        $area = $_POST['area'];
        $lndmark = $_POST['landmark'];
        $city = $_POST['city'];
        $zcode = $_POST['zipcode'];
        $state = $_POST['state'];
        $userid = $_SESSION['ofsmsuid'];
        $patype = $_POST['paytype'];
        $ordernumber = mt_rand(100000000, 999999999);

        $sql = "INSERT INTO tblorder (OrderNumber, UserID, FullName, ContactNumber, FlatNo, StreetName, Area, Landmark, City, Zipcode, State, payType) 
                VALUES (:ordernumber, :userid, :fname, :cnumber, :fnaobno, :street, :area, :lndmark, :city, :zcode, :state, :patype)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':ordernumber', $ordernumber, PDO::PARAM_STR);
        $query->bindParam(':userid', $userid, PDO::PARAM_STR);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':cnumber', $cnumber, PDO::PARAM_STR);
        $query->bindParam(':fnaobno', $fnaobno, PDO::PARAM_STR);
        $query->bindParam(':street', $street, PDO::PARAM_STR);
        $query->bindParam(':area', $area, PDO::PARAM_STR);
        $query->bindParam(':lndmark', $lndmark, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':zcode', $zcode, PDO::PARAM_STR);
        $query->bindParam(':state', $state, PDO::PARAM_STR);
        $query->bindParam(':patype', $patype, PDO::PARAM_STR);
        $query->execute();
        $LastInsertId = $dbh->lastInsertId();

        if ($LastInsertId > 0) {
            $quantity = $_POST['quantity'];
            $pdd = $_SESSION['pid'];
            $value = array_combine($pdd, $quantity);

            foreach ($value as $pdid => $qty) {
                $sql = "INSERT INTO tblorderdetails (UserId, OrderNumber, ProductId, ProductQty) 
                        VALUES (:userid, :ordernumber, :pdid, :qty)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':ordernumber', $ordernumber, PDO::PARAM_STR);
                $query->bindParam(':userid', $userid, PDO::PARAM_STR);
                $query->bindParam(':pdid', $pdid, PDO::PARAM_STR);
                $query->bindParam(':qty', $qty, PDO::PARAM_STR);
                $query->execute();
            }

            echo '<script>alert("Your Order Has Been Placed.")</script>';
            unset($_SESSION["cart_item"]);
            unset($_SESSION['tprice']);
            echo "<script>window.location.href ='index.php'</script>";
        } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Online Furniture Store Management System || Cart Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Furniture Shop" />
    <style>
        /* Custom CSS for the page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .header, .footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .cart_main {
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .breadcrumb {
            margin-bottom: 20px;
        }
        .breadcrumb a {
            color: #333;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .cart-items {
            margin-top: 20px;
        }
        .cart-items h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .cart-items table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .cart-items table th, .cart-items table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .cart-items table th {
            background-color: #f5f5f5;
        }
        .cart-total {
            margin-top: 20px;
        }
        .cart-total .continue {
            color: #333;
            text-decoration: none;
            font-weight: bold;
        }
        .cart-total .price-details {
            margin-top: 20px;
        }
        .cart-total .price-details h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .cart-total .price-details span {
            display: block;
            margin-bottom: 5px;
        }
        .cart-total .price-details .total {
            font-weight: bold;
        }
        .cart-total .last-price {
            font-size: 18px;
            margin-top: 20px;
        }
        .cart-total .final {
            font-weight: bold;
        }
        .cart-total input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }
        .cart-total input[type="submit"]:hover {
            background-color: #218838;
        }
        .no-records {
            font-size: 18px;
            color: #999;
            text-align: center;
            margin-top: 20px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
        }
        .form-control-alternative {
            border: 1px solid #000;
        }
        .clearfix {
            clear: both;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include_once('includes/header.php'); ?>

    <!-- Cart Main -->
    <div class="cart_main">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li class="active">Cart</li>
            </ol>
            <div class="cart-items">
                <h2>My Shopping Bag</h2>
                <form action="" method="post">
                    <div id="shopping-cart">
                        <?php
                        if (isset($_SESSION["cart_item"])) {
                            $total_quantity = 0;
                            $total_price = 0;
                        ?>
                            <a id="btnEmpty" href="cart.php?action=empty" style="color:red">Empty Cart</a>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Code</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $pdtid = array();
                                    foreach ($_SESSION["cart_item"] as $item) {
                                        $item_price = $item["quantity"] * $item["price"];
                                        array_push($pdtid, $item['code']);
                                    ?>
                                        <tr>
                                            <td><img src="admin/images/<?php echo $item["image"]; ?>" height="100" width="200" /></td>
                                            <td><?php echo $item["name"]; ?></td>
                                            <td><?php echo $pd = $item["code"];
                                                $_SESSION['pid'] = $pdtid;
                                                ?></td>
                                            <td><?php echo $item["quantity"]; ?></td>
                                            <td>Rs. <?php echo $item["price"]; ?></td>
                                            <td>Rs. <?php echo number_format($item_price, 2); ?></td>
                                            <input type="hidden" value="<?php echo $item['quantity']; ?>" name="quantity[<?php echo $item['code']; ?>]">
                                        </tr>
                                    <?php
                                        $total_quantity += $item["quantity"];
                                        $total_price += ($item["price"] * $item["quantity"]);
                                    }
                                    $_SESSION['tprice'] = $total_price;
                                    ?>
                                    <tr>
                                        <td colspan="3" align="right">Total:</td>
                                        <td><?php echo $total_quantity; ?></td>
                                        <td colspan="2"><strong>Rs. <?php echo number_format($total_price, 2); ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="cart-total">
                                <a class="continue" href="index.php">Continue to basket</a>
                                <div class="price-details">
                                    <h3>Price Details</h3>
                                    <span>Total</span>
                                    <span class="total">Rs. <?php echo number_format($total_price, 2); ?></span>
                                    <div class="clearfix"></div>
                                </div>
                                <h4 class="last-price">TOTAL</h4>
                                <span class="total final">Rs. <?php echo number_format($total_price, 2); ?></span>
                                <div class="clearfix"></div>
                                <input type="submit" value="Place Order" name="submit" id="submit">
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="no-records">Your Cart is Empty</div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    if (isset($_SESSION["cart_item"])) {
                    ?>
                        <p style="color: red; padding-bottom: 20px;">Fill The Following Details</p>
                        <div style="padding-bottom: 20px;">
                            <label>
                                Payment Type:<br />
                                <input type="radio" value="Cash on Delivery" required name="paytype"> COD (Cash on Delivery)
                            </label>
                            <hr />
                            <label>
                                <input type="text" class="form-control" placeholder="Full Name" name="fname" id="fname" required="true">
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="text" class="form-control" placeholder="Contact Number" name="cnumber" id="cnumber" required="true" maxlength="10" pattern="[0-9]+">
                            </label>
                        </div>
                        <br />
                        <div style="padding-bottom: 20px;">
                            <label>
                                <input type="text" class="form-control" placeholder="Flat or Building Number" name="flatbldgnumber" id="flatbldgnumber" required="true">
                            </label>
                        </div>
                        <div style="padding-bottom: 20px;">
                            <label>
                                <input type="text" class="form-control" placeholder="Street Name" name="streename" id="streename" required="true">
                            </label>
                        </div>
                        <div style="padding-bottom: 20px;">
                            <label>
                                <input type="text" class="form-control" placeholder="Area" name="area" id="area" required="true">
                            </label>
                        </div>
                        <div style="padding-bottom: 20px;">
                            <label>
                                <input type="text" class="form-control" placeholder="Landmark" name="landmark" id="landmark" required="true">
                            </label>
                        </div>
                        <div style="padding-bottom: 20px;">
                            <label>
                                <input type="text" class="form-control" placeholder="City" name="city" id="city" required="true">
                            </label>
                        </div>
                        <div style="padding-bottom: 20px;">
                            <label>
                                <input type="text" class="form-control" placeholder="Zip Code" name="zipcode" id="zipcode" required="true">
                            </label>
                        </div>
                        <div style="padding-bottom: 20px;">
                            <label>
                                <input type="text" class="form-control" placeholder="State" name="state" id="state" required="true">
                            </label>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>
</body>
</html>