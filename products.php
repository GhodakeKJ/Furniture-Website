<?php
session_start();
error_reporting(0);
include('db.php');
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Online Furniture Management System | Products</title>
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
        .product-model {
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
        .product-grid {
            display: inline-block;
            width: 23%;
            margin: 1%;
            border: 1px solid #ddd;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .product-grid img {
            max-width: 100%;
            height: auto;
        }
        .product-info {
            margin-top: 10px;
        }
        .product-info h4 {
            font-size: 18px;
            margin: 10px 0;
        }
        .product-info p {
            margin: 5px 0;
        }
        .item_price {
            font-size: 20px;
            color: #28a745;
            font-weight: bold;
        }
        .item_quantity {
            width: 50px;
            padding: 5px;
            margin: 10px 0;
        }
        .item_add {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }
        .item_add:hover {
            background-color: #218838;
        }
        @media (max-width: 768px) {
            .product-grid {
                width: 48%;
            }
        }
        @media (max-width: 480px) {
            .product-grid {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include_once('header.php'); ?>

    <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li><a href="index.html">Home</a></li>
            <li class="single-product-detail.php">Products</li>
        </ol>
        <h2>OUR PRODUCTS</h2>

    </div>

    <!-- Product Grid -->
    <div class="product-model">
        <div class="container">
            <?php
            $sql = "SELECT * FROM tblproducts";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                foreach ($results as $row) {
            ?>
                    <div class="product-grid">
                        <a href="single-product.php?pid=<?php echo $row->ID; ?>">
                            <div class="product-img">
                                <img src="admin/images<?php echo $row->Image; ?>" height="200" alt="<?php echo $row->ProductTitle; ?>">
                            </div>
                        </a>
                        <div class="product-info">
                            <h4><?php echo substr($row->ProductTitle, 0, 20); ?></h4>
                            <p>ID: <?php echo $row->ProductID; ?></p>
                            <span class="item_price">Rs. <?php echo $row->SalePrice; ?></span>
                            <form method="POST" action="cart.php">
                                <input type="hidden" name="product_id" value="<?php echo $row->ID; ?>">
                                <input type="text" class="item_quantity" name="quantity" value="1">
                                <input type="submit" class="item_add" name="add_to_cart" value="ADD">
                            </form>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No products found.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('footer.php'); ?>
</body>
</html>