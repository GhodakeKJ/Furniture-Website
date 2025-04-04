
<?php
session_start();
include('db.php');
if (strlen($_SESSION['ofsmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $ofsmsaid = $_SESSION['ofsmsaid'];
        $catid = $_POST['catid'];
        $ptitle = $_POST['ptitle'];
        $rprice = $_POST['regularprice'];
        $brandname = $_POST['brandname'];
        $qty = $_POST['qty'];
        $pdesc = $_POST['pdesc'];
        $saleprice = $_POST['saleprice'];
        $subcategory = $_POST['subcategory'];
        $availability = $_POST['availability'];
        $ProductID = mt_rand(100000000, 999999999);

        // Product Images
        $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");

        function uploadImage($imageFile) {
            global $allowed_extensions;
            $extension = substr($imageFile["name"], strlen($imageFile["name"]) - 4, strlen($imageFile["name"]));
            if (!in_array($extension, $allowed_extensions)) {
                return false;
            }
            $filename = md5($imageFile["name"]) . time() . $extension;
            move_uploaded_file($imageFile["tmp_name"], "\category images\images" . $filename);
            return $filename;
        }

        $propic = uploadImage($_FILES["image"]);
        $propic1 = uploadImage($_FILES["image1"]);
        $propic2 = uploadImage($_FILES["image2"]);
        $propic3 = uploadImage($_FILES["image3"]);

        if ($propic && $propic1 && $propic2 && $propic3) {
            $sql = "INSERT INTO tblproducts(ProductID, CatID, SubCatid, ProductTitle, RegularPrice, BrandName, Quantity, PDesc, SalePrice, Image, Image1, Image2, Image3, Availability) 
                    VALUES (:pid, :catid, :scatid, :title, :rprice, :bname, :qty, :pdesc, :sprice, :img, :img1, :img2, :img3, :availability)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':pid', $ProductID, PDO::PARAM_STR);
            $query->bindParam(':catid', $catid, PDO::PARAM_STR);
            $query->bindParam(':title', $ptitle, PDO::PARAM_STR);
            $query->bindParam(':rprice', $rprice, PDO::PARAM_STR);
            $query->bindParam(':bname', $brandname, PDO::PARAM_STR);
            $query->bindParam(':qty', $qty, PDO::PARAM_STR);
            $query->bindParam(':pdesc', $pdesc, PDO::PARAM_STR);
            $query->bindParam(':sprice', $saleprice, PDO::PARAM_STR);
            $query->bindParam(':scatid', $subcategory, PDO::PARAM_STR);
            $query->bindParam(':availability', $availability, PDO::PARAM_STR);
            $query->bindParam(':img', $propic, PDO::PARAM_STR);
            $query->bindParam(':img1', $propic1, PDO::PARAM_STR);
            $query->bindParam(':img2', $propic2, PDO::PARAM_STR);
            $query->bindParam(':img3', $propic3, PDO::PARAM_STR);
            $query->execute();

            $LastInsertId = $dbh->lastInsertId();
            if ($LastInsertId > 0) {
                echo '<script>alert("Product detail has been added.")</script>';
                echo "<script>window.location.href ='add-products.php'</script>";
            } else {
                echo '<script>alert("Something Went Wrong. Please try again")</script>';
            }
        } else {
            echo '<script>alert("Invalid image format. Only jpg, jpeg, png, gif allowed.")</script>';
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products | Furniture Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        label {
            font-size: 14px;
            color: #333;
        }

        input[type="text"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        textarea {
            resize: vertical;
        }

        button {
            grid-column: span 2;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Add Product</h1>
        <form action="#" method="post" enctype="multipart/form-data">
            <label for="ptitle">Product Title</label>
            <input type="text" name="ptitle" id="ptitle" required>

            <label for="regularprice">Regular Price</label>
            <input type="text" name="regularprice" id="regularprice" required>

            <label for="brandname">Brand Name</label>
            <select name="brandname" id="brandname" required>
                <option value="">Select Brand</option>
                <!-- Fetch brand options from the database -->
            </select>

            <label for="availability">Availability</label>
            <select name="availability" id="availability" required>
                <option value="">Select Availability</option>
                <option value="Instock">In stock</option>
                <option value="Outstock">Out of stock</option>
            </select>

            <label for="qty">Quantity</label>
            <input type="text" name="qty" id="qty" required>

            <label for="pdesc">Product Description</label>
            <textarea name="pdesc" id="pdesc" rows="4" required></textarea>

            <label for="saleprice">Sale Price</label>
            <input type="text" name="saleprice" id="saleprice" required>

            <label for="catid">Category</label>
            <select name="catid" id="catid" required>
                <option value="">Select Category</option>
                <!-- Fetch category options from the database -->
            </select>

            <label for="subcategory">Subcategory</label>
            <select name="subcategory" id="subcategory" required>
                <option value="">Select Subcategory</option>
            </select>

            <label for="image">Product Image</label>
            <input type="file" name="image" id="image" required>

            <label for="image1">Product Image 1</label>
            <input type="file" name="image1" id="image1" required>

            <label for="image2">Product Image 2</label>
            <input type="file" name="image2" id="image2" required>

            <label for="image3">Product Image 3</label>
            <input type="file" name="image3" id="image3" required>

            <button type="submit" name="submit">Add Product</button>
        </form>
    </div>

</body>

</html>
