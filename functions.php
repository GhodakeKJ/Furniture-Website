<?php
// Establishing the connection to the database
$db = mysqli_connect("localhost", "root", "", "furniture");

// Function to get the real IP address of the user
function getRealIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) { // check IP from shared internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { // check if IP is passed from a proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR']; // default IP address
    }
    return $ip;
}

// Function to handle adding products to the cart
function cart() {
    global $db;
    if (isset($_GET['add_cart'])) {
        $ip_add = getRealIpAddr();
        $p_id = $_GET['add_cart'];
        $check_pro = "SELECT * FROM cart WHERE ip_add='$ip_add' AND p_id='$p_id'";
        $run_check = mysqli_query($db, $check_pro);

        if (mysqli_num_rows($run_check) == 0) {
            $q = "INSERT INTO cart (p_id, ip_add, qty) VALUES ('$p_id', '$ip_add', 1)";
            $run_q = mysqli_query($db, $q);
            echo "<script>window.open('all_products.php', '_self')</script>";
        }
    }
}

// Function to get the number of items in the cart
function items() {
    global $db;
    $ip_add = getRealIpAddr();
    $get_items = "SELECT * FROM cart WHERE ip_add='$ip_add'";
    $run_items = mysqli_query($db, $get_items);
    $count_items = mysqli_num_rows($run_items);
    echo $count_items;
}

// Function to get the total price of items in the cart
function total_price() {
    global $db;
    $ip_add = getRealIpAddr();
    $total = 0;

    $sel_price = "SELECT * FROM cart WHERE ip_add='$ip_add'";
    $run_price = mysqli_query($db, $sel_price);

    while ($record = mysqli_fetch_array($run_price)) {
        $pro_id = $record['p_id'];
        $qty = $record['qty'];

        $pro_price = "SELECT * FROM products WHERE product_id='$pro_id'";
        $run_pro_price = mysqli_query($db, $pro_price);

        while ($p_price = mysqli_fetch_array($run_pro_price)) {
            $product_price = array($p_price['product_price']);
            $values = array_sum($product_price) * $qty;
            $total += $values;
        }
    }

    echo $total;
}

// Function to get and display products (limit 6, random)
function getPro() {
    global $db;

    if (!isset($_GET['cat']) && !isset($_GET['brand'])) {
        $get_products = "SELECT * FROM products ORDER BY RAND() LIMIT 0,6";
        $run_products = mysqli_query($db, $get_products);

        while ($row_products = mysqli_fetch_array($run_products)) {
            $pro_id = $row_products['product_id'];
            $pro_title = $row_products['product_title'];
            $pro_price = $row_products['product_price'];
            $pro_image = $row_products['product_img1'];

            echo "
            <div id='single_product'>
                <h3>$pro_title</h3>
                <img src='admin_area/product_images/$pro_image' width='180' height='180'/><br>
                <p><b>Price: $$pro_price</b></p>
                <a href='all_products.php?add_cart=$pro_id'><span>Add to Cart</span></a>
                <a href='details.php?pro_id=$pro_id'>Show Details</a>
            </div>
            ";
        }
    }
}

// Function to get products by category
function getCatPro() {
    global $db;

    if (isset($_GET['cat'])) {
        $cat_id = $_GET['cat'];
        $get_cat_pro = "SELECT * FROM products WHERE cat_id='$cat_id'";
        $run_cat_pro = mysqli_query($db, $get_cat_pro);
        $count = mysqli_num_rows($run_cat_pro);

        if ($count == 0) {
            echo "<h2>No products found in this category!</h2>";
        } else {
            while ($row_cat_pro = mysqli_fetch_array($run_cat_pro)) {
                $pro_id = $row_cat_pro['product_id'];
                $pro_title = $row_cat_pro['product_title'];
                $pro_price = $row_cat_pro['product_price'];
                $pro_image = $row_cat_pro['product_img1'];

                echo "
                <div id='single_product'>
                    <h3>$pro_title</h3>
                    <img src='admin_area/product_images/$pro_image' width='180' height='180'/><br>
                    <p><b>Price: $$pro_price</b></p>
                    <a href='all_products.php?add_cart=$pro_id'><span>Add to Cart</span></a>
                    <a href='details.php?pro_id=$pro_id'>Show Details</a>
                </div>
                ";
            }
        }
    }
}

// Function to get products by brand
function getBrandPro() {
    global $db;

    if (isset($_GET['brand'])) {
        $brand_id = $_GET['brand'];
        $get_brand_pro = "SELECT * FROM products WHERE brand_id='$brand_id'";
        $run_brand_pro = mysqli_query($db, $get_brand_pro);
        $count = mysqli_num_rows($run_brand_pro);

        if ($count == 0) {
            echo "<h2>No products found in this brand!</h2>";
        } else {
            while ($row_brand_pro = mysqli_fetch_array($run_brand_pro)) {
                $pro_id = $row_brand_pro['product_id'];
                $pro_title = $row_brand_pro['product_title'];
                $pro_price = $row_brand_pro['product_price'];
                $pro_image = $row_brand_pro['product_img1'];

                echo "
                <div id='single_product'>
                    <h3>$pro_title</h3>
                    <img src='admin_area/product_images/$pro_image' width='180' height='180'/><br>
                    <p><b>Price: $$pro_price</b></p>
                    <a href='all_products.php?add_cart=$pro_id'><span>Add to Cart</span></a>
                    <a href='details.php?pro_id=$pro_id'>Show Details</a>
                </div>
                ";
            }
        }
    }
}

// Function to display the brands list
function getBrands() {
    global $db;

    $get_brands = "SELECT * FROM brands";
    $run_brands = mysqli_query($db, $get_brands);

    while ($row_brands = mysqli_fetch_array($run_brands)) {
        $brand_id = $row_brands['brand_id'];
        $brand_title = $row_brands['brand_title'];
        echo "<li><a href='all_products.php?brand=$brand_id'>$brand_title</a></li>";
    }
}

// Function to display the categories list
function getCats() {
    global $db;

    $get_cats = "SELECT * FROM categories";
    $run_cats = mysqli_query($db, $get_cats);

    while ($row_cats = mysqli_fetch_array($run_cats)) {
        $cat_id = $row_cats['cat_id'];
        $cat_title = $row_cats['cat_title'];
        echo "<li><a href='all_products.php?cat=$cat_id'>$cat_title</a></li>";
    }
}

?>
