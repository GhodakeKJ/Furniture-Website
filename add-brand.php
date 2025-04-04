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
        $logo = $_FILES["logo"]["name"];
        $extension = substr($logo, strlen($logo) - 4, strlen($logo));
        $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");

        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Logo has Invalid format. Only jpg / jpeg / png / gif format allowed');</script>";
        } else {
            $logo = md5($logo) . time() . $extension;
            move_uploaded_file($_FILES["logo"]["tmp_name"], "category images\images" . $logo);

            $sql = "INSERT INTO tblbrand (BrandName, Logo) VALUES (:bname, :logo)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':bname', $bname, PDO::PARAM_STR);
            $query->bindParam(':logo', $logo, PDO::PARAM_STR);
            $query->execute();

            $LastInsertId = $dbh->lastInsertId();
            if ($LastInsertId > 0) {
                echo "<script>alert('Brand has been added.')</script>";
                echo "<script>window.location.href ='add-brand.php'</script>";
            } else {
                echo "<script>alert('Something Went Wrong. Please try again.')</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Brand | Furniture Store Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .alert {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Add Brand</h1>

        <form action="#" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="brandname">Brand Name</label>
                <input type="text" name="brandname" id="brandname" required>
            </div>

            <div class="form-group">
                <label for="logo">Brand Logo</label>
                <input type="file" name="logo" id="logo" required>
            </div>

            <div class="form-group">
                <button type="submit" name="submit">Add Brand</button>
            </div>
        </form>
    </div>
</body>

</html>
