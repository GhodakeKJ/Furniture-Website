<?php
session_start();
error_reporting(0);
include('db.php');
if (strlen($_SESSION['ofsmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {

        $ofsmsaid = $_SESSION['ofsmsaid'];
        $bname = $_POST['brandname'];
        $eid = $_GET['editid'];
        $sql = "UPDATE tblbrand SET BrandName=:bname WHERE ID=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bname', $bname, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();

        echo '<script>alert("Brand name has been updated")</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Brand | Online Furniture Store Management System</title>
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
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group img {
            margin-top: 10px;
        }

        .form-group a {
            display: inline-block;
            margin-top: 10px;
            color: #007BFF;
            text-decoration: none;
        }

        .form-group a:hover {
            text-decoration: underline;
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Update Brand</h1>
        <form action="#" method="post" enctype="multipart/form-data">
            <?php
            $eid = $_GET['editid'];
            $sql = "SELECT * FROM tblbrand WHERE ID=$eid";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $cnt = 1;
            if ($query->rowCount() > 0) {
                foreach ($results as $row) {
            ?>
                    <div class="form-group">
                        <label for="brandname">Brand Name</label>
                        <input type="text" name="brandname" id="brandname" value="<?php echo $row->BrandName; ?>" required="true">
                    </div>
                    <div class="form-group">
                        <label for="brandlogo">Brand Logo</label>
                        <img src="images/<?php echo $row->Logo; ?>" width="100" height="100">
                        <a href="changeimage.php?editid=<?php echo $row->ID; ?>">Edit Image</a>
                    </div>
            <?php $cnt = $cnt + 1;
                }
            } ?>
            <button class="submit-btn" type="submit" name="submit" id="submit">Update</button>
        </form>
    </div>

</body>

</html>
<?php } ?>
