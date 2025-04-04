
<?php
session_start();
error_reporting(0);
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
        $eid = $_GET['editid'];
        $ProductID = mt_rand(100000000, 999999999);

        $sql = "UPDATE tblproducts SET CatID=:catid, SubCatid=:scatid, ProductTitle=:title, RegularPrice=:rprice, BrandName=:bname, Quantity=:qty, PDesc=:pdesc, SalePrice=:sprice, Availability=:availability WHERE ID=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':catid', $catid, PDO::PARAM_STR);
        $query->bindParam(':title', $ptitle, PDO::PARAM_STR);
        $query->bindParam(':rprice', $rprice, PDO::PARAM_STR);
        $query->bindParam(':bname', $brandname, PDO::PARAM_STR);
        $query->bindParam(':qty', $qty, PDO::PARAM_STR);
        $query->bindParam(':pdesc', $pdesc, PDO::PARAM_STR);
        $query->bindParam(':sprice', $saleprice, PDO::PARAM_STR);
        $query->bindParam(':scatid', $subcategory, PDO::PARAM_STR);
        $query->bindParam(':availability', $availability, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();
        echo '<script>alert("Products have been updated")</script>';
    }
?>

<!doctype html>
<html lang="en">

<head>
    <title>Update Products | Online Furniture Store Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group img {
            margin-top: 10px;
        }

        .form-group a {
            display: inline-block;
            margin-left: 10px;
            color: blue;
            text-decoration: underline;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Update Product</h2>
        <form action="#" method="post" enctype="multipart/form-data">
            <?php
            $eid = $_GET['editid'];
            $sql = "SELECT tblcategory.CategoryName, tblsubcategory.ID as subcatid, tblsubcategory.SubcategoryName, tblproducts.* FROM tblproducts 
            INNER JOIN tblcategory ON tblcategory.ID = tblproducts.CatID 
            INNER JOIN tblsubcategory ON tblsubcategory.ID = tblproducts.SubCatid 
            WHERE tblproducts.ID=:eid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':eid', $eid, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                foreach ($results as $row) {
            ?>
                    <div class="form-group">
                        <label for="ptitle">Product Title</label>
                        <input type="text" name="ptitle" value="<?php echo $row->ProductTitle; ?>" required="true">
                    </div>

                    <div class="form-group">
                        <label for="regularprice">Regular Price</label>
                        <input type="text" name="regularprice" value="<?php echo $row->RegularPrice; ?>" required="true">
                    </div>

                    <div class="form-group">
                        <label for="brandname">Brand Name</label>
                        <select name="brandname" required="true">
                            <option value="<?php echo $row->BrandName; ?>"><?php echo $row->BrandName; ?></option>
                            <?php
                            $sql2 = "SELECT * from tblbrand";
                            $query2 = $dbh->prepare($sql2);
                            $query2->execute();
                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                            foreach ($result2 as $row1) { ?>
                                <option value="<?php echo htmlentities($row1->BrandName); ?>"><?php echo htmlentities($row1->BrandName); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="availability">Availability</label>
                        <select name="availability" required="true">
                            <option value="<?php echo $row->Availability; ?>"><?php echo $row->Availability; ?></option>
                            <option value="Instock">In stock</option>
                            <option value="Outstock">Out of stock</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input type="text" name="qty" value="<?php echo $row->Quantity; ?>" required="true">
                    </div>

                    <div class="form-group">
                        <label for="pdesc">Product Description</label>
                        <textarea name="pdesc" required="true"><?php echo $row->PDesc; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="saleprice">Sales Price</label>
                        <input type="text" name="saleprice" value="<?php echo $row->SalePrice; ?>" required="true">
                    </div>

                    <div class="form-group">
                        <label for="catid">Category</label>
                        <select name="catid" required="true">
                            <option value="<?php echo $row->CatID; ?>"><?php echo $row->CategoryName; ?></option>
                            <?php
                            $sql2 = "SELECT * from tblcategory";
                            $query2 = $dbh->prepare($sql2);
                            $query2->execute();
                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                            foreach ($result2 as $row1) { ?>
                                <option value="<?php echo htmlentities($row1->ID); ?>"><?php echo htmlentities($row1->CategoryName); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subcategory">Subcategory</label>
                        <select name="subcategory" required="true">
                            <option value="<?php echo $row->SubCatid; ?>"><?php echo $row->SubcategoryName; ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <img src="images/<?php echo $row->Image; ?>" width="100" height="100">
                        <a href="changeimage1.php?editid=<?php echo $row->ID; ?>">Edit Image</a>
                    </div>

                    <div class="form-group">
                        <label for="image1">Image1</label>
                        <img src="images/<?php echo $row->Image1; ?>" width="100" height="100">
                        <a href="changeimage2.php?editid=<?php echo $row->ID; ?>">Edit Image1</a>
                    </div>

                    <div class="form-group">
                        <label for="image2">Image2</label>
                        <img src="images/<?php echo $row->Image2; ?>" width="100" height="100">
                        <a href="changeimage3.php?editid=<?php echo $row->ID; ?>">Edit Image2</a>
                    </div>

                    <div class="form-group">
                        <label for="image3">Image3</label>
                        <img src="images/<?php echo $row->Image3; ?>" width="100" height="100">
                        <a href="changeimage4.php?editid=<?php echo $row->ID; ?>">Edit Image3</a>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="submit" class="btn">Update</button>
                    </div>

            <?php }
            } ?>
        </form>
    </div>

</body>

</html>
<?php } ?>
