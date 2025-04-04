
<?php
session_start();
error_reporting(0);
include('db.php');
if (strlen($_SESSION['ofsmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {

        $ofsmsaid = $_SESSION['ofsmsaid'];
        $cname = $_POST['cname'];
        $eid = $_GET['editid'];
        $sql = "UPDATE tblcategory SET CategoryName=:cname WHERE ID=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cname', $cname, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);

        $query->execute();

        echo '<script>alert("Category has been updated")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Category | Furniture Store Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #007bff;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Update Category</h1>

        <form action="" method="post">
            <?php
            $eid = $_GET['editid'];
            $sql = "SELECT * FROM tblcategory WHERE ID=$eid";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() > 0) {
                foreach ($results as $row) {
            ?>
                    <div class="form-group">
                        <label for="cname">Category Name</label>
                        <input type="text" name="cname" id="cname" value="<?php echo $row->CategoryName; ?>" required>
                    </div>

            <?php
                }
            }
            ?>

            <button type="submit" name="submit" class="btn-submit">Update</button>
        </form>

        <div class="back-link">
            <a href="category-list.php">Back to Category List</a>
        </div>
    </div>
</body>

</html>
