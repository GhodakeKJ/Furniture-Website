
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
                $sql = $dbh->prepare("SELECT * FROM tblproducts WHERE ID = :pid");
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
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products | Online Furniture Management System</title>
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
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .product-item {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            width: calc(33.33% - 20px);
            box-sizing: border-box;
            text-align: center;
        }
        .product-item img {
            max-width: 100%;
            height: auto;
        }
        .product-item h4 {
            margin: 10px 0;
            color: #333;
        }
        .product-item p {
            margin: 5px 0;
            color: #555;
        }
        .product-item .item_price {
            font-weight: bold;
            color: #007bff;
        }
        .product-item input[type="text"] {
            width: 50px;
            padding: 5px;
            margin: 10px 0;
        }
        .product-item input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .product-item input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .clearfix {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
        </ol>
        <h2>OUR PRODUCTS</h2>
        <div class="product-grid">
            <?php
            $cid = intval($_GET['catid']);
            $sql = "SELECT * FROM tblproducts WHERE CatID = :cid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':cid', $cid, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $cnt = 1;
            if ($query->rowCount() > 0) {
                foreach ($results as $row) {
                    ?>
                    <form method="post" action="category-details.php?action=add&pid=<?php echo $row->ID; ?>">
                        <div class="product-item">
                            <a href="single-product-detail.php?proid=<?php echo $row->ID; ?>">
                                <img src="category images\images<?php echo $row->Image; ?>" alt="<?php echo $row->ProductTitle; ?>" height="200" width="200">
                                <h4><?php echo $row->ProductTitle; ?></h4>
                                <p>ID: <?php echo $row->ProductID; ?></p>
                                <p style="color:red"><?php echo $row->Availability; ?></p>
                                <span class="item_price">Rs. <?php echo $row->SalePrice; ?></span>
                            </a>
                            <?php if ($row->Availability == 'Instock'): ?>
                                <input type="text" name="quantity" value="1" />
                                <input type="submit" value="Add to Cart" />
                            <?php endif; ?>
                        </div>
                    </form>
                    <?php
                    $cnt = $cnt + 1;
                }
            } else {
                echo "<h3 style='color:red; text-align:center;'>No record found against this category</h3>";
            }
            ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php include_once('footer.php'); ?>
</body>
</html>