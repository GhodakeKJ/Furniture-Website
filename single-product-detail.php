<?php
session_start();
error_reporting(0);
include('db.php');

// Code for Cart
if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        // Code for adding product to cart
        case "add":
            if (!empty($_POST["quantity"])) {
                $pid = $_GET["pid"];
                $sql = $dbh->prepare("SELECT * FROM tblproducts WHERE ID=:pid");
                $sql->execute(array(':pid' => $pid));
                while ($productByCode = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $itemArray = array(
                        $productByCode["ID"] => array(
                            'name' => $productByCode["ProductTitle"],
                            'code' => $productByCode["ID"],
                            'quantity' => $_POST["quantity"],
                            'price' => $productByCode["SalePrice"],
                            'image' => $productByCode["Image"]
                        )
                    );

                    if (!empty($_SESSION["cart_item"])) {
                        if (in_array($productByCode["ID"], array_keys($_SESSION["cart_item"]))) {
                            foreach ($_SESSION["cart_item"] as $k => $v) {
                                if ($productByCode["ID"] == $k) {
                                    if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                        $_SESSION["cart_item"][$k]["quantity"] = 0;
                                    }
                                    $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                                }
                            }
                        } else {
                            $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                        }
                    } else {
                        $_SESSION["cart_item"] = $itemArray;
                    }
                }
            }
            header('location:cart.php');
            break;

        // Code for removing product from cart
        case "remove":
            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    if ($_GET["code"] == $k) {
                        unset($_SESSION["cart_item"][$k]);
                    }
                    if (empty($_SESSION["cart_item"])) {
                        unset($_SESSION["cart_item"]);
                    }
                }
            }
            header('location:cart.php');
            break;

        // Code for emptying the cart
        case "empty":
            unset($_SESSION["cart_item"]);
            header('location:cart.php');
            break;
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Online Furniture Management System | Single Product</title>
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
        .single-sec {
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
        .single-left, .single-right {
            display: inline-block;
            vertical-align: top;
            width: 48%;
            margin: 1%;
        }
        .single-left img {
            max-width: 100%;
            height: auto;
        }
        .single-right h3 {
            font-size: 24px;
            margin: 10px 0;
        }
        .single-right .id h4 {
            font-size: 18px;
            margin: 5px 0;
        }
        .single-right .cost {
            margin: 20px 0;
        }
        .single-right .cost ul {
            list-style: none;
            padding: 0;
        }
        .single-right .cost ul li {
            margin: 10px 0;
        }
        .single-right .cost ul li del {
            color: #999;
        }
        .single-right .cost ul li span {
            color: #28a745;
            font-weight: bold;
        }
        .single-right .item_quantity {
            width: 50px;
            padding: 5px;
            margin: 10px 0;
        }
        .single-right .btnAddAction {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }
        .single-right .btnAddAction:hover {
            background-color: #218838;
        }
        .single-bottom1 {
            margin-top: 20px;
        }
        .single-bottom1 h6 {
            font-size: 18px;
            margin: 10px 0;
        }
        .single-bottom1 .prod-desc {
            font-size: 14px;
            line-height: 1.6;
        }
        @media (max-width: 768px) {
            .single-left, .single-right {
                width: 100%;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include_once('header.php'); ?>

    <!-- Breadcrumb -->
    <div class="single-sec">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li class="active">Products</li>
            </ol>
            <!-- Start Content -->
            <div class="det">
                <?php
                $pid = intval($_GET['proid']);
                $sql = "SELECT *, tblproducts.ID as pid FROM tblproducts 
                        JOIN tblcategory ON tblcategory.ID = tblproducts.CatID
                        JOIN tblsubcategory ON tblsubcategory.ID = tblproducts.SubCatid
                        WHERE tblproducts.ID = :pid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':pid', $pid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if ($query->rowCount() > 0) {
                    foreach ($results as $row) {
                ?>
                        <div class="single-left">
                            <form method="post" action="category-details.php?action=add&pid=<?php echo $row->pid; ?>">
                                <div class="grid">
                                    <img src="furniture/bag.png/<?php echo $row->Image; ?>" class="img-responsive" width="300" height="300" />
                                </div>
                        </div>
                        <div class="single-right">
                            <h3><?php echo $row->ProductTitle; ?></h3>
                            <div class="id"><h4>ID: <?php echo $row->ProductID; ?></h4></div>
                            <div class="id"><h4>Category: <?php echo $row->CategoryName; ?></h4></div>
                            <div class="id"><h4>Sub-category: <?php echo $row->SubcategoryName; ?></h4></div>
                            <div class="id"><h4>Brand: <?php echo $row->BrandName; ?></h4></div>
                            <div class="cost">
                                <ul>
                                    <li>MRP: <del>Rs. <?php echo $row->RegularPrice; ?></del></li>
                                    <li><strong>Selling Price:</strong> <span style="color:red">Rs. <?php echo $row->SalePrice; ?></span></li>
                                    <p style="color:red"><?php echo $row->Availability; ?></p>
                                    <?php if ($row->Availability == 'Instock') : ?>
                                        <input type="text" class="item_quantity" name="quantity" value="1" />
                                        <input type="submit" value="Add to Cart" class="btnAddAction" />
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="single-bottom1">
                                <h6>Details</h6>
                                <p class="prod-desc"><?php echo $row->PDesc; ?></p>
                            </div>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                <?php
                        $cnt = $cnt + 1;
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('footer.php'); ?>
</body>
</html>