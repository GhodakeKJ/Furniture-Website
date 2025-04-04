
<?php
session_start();
include('db.php');

if (strlen($_SESSION['ofsmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $ofsmsaid = $_SESSION['ofsmsaid'];
        $catid = $_POST['cat'];
        $scname = $_POST['scname'];
        $eid = $_GET['editid'];

        $sql = "UPDATE tblsubcategory SET CatID=:catid, SubcategoryName=:scname WHERE ID=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':catid', $catid, PDO::PARAM_STR);
        $query->bindParam(':scname', $scname, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();

        echo '<script>alert("Subcategory has been updated")</script>';
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Subcategory | Online Furniture Store Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .row .col {
            flex: 1;
        }

        .col + .col {
            margin-left: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Update Subcategory</h1>

        <form action="" method="post">
            <?php
            $eid = $_GET['editid'];
            $sql = "SELECT tblcategory.CategoryName, tblsubcategory.ID as subcatid, tblsubcategory.SubcategoryName, tblsubcategory.CreationDate 
                    FROM tblsubcategory 
                    INNER JOIN tblcategory ON tblcategory.ID = tblsubcategory.CatID 
                    WHERE tblsubcategory.ID=:eid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':eid', $eid, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() > 0) {
                foreach ($results as $row) {
            ?>
                    <div class="form-group">
                        <label for="cat">Category Name</label>
                        <select name="cat" id="cat" required>
                            <option value="<?php echo $row->subcatid; ?>"><?php echo $row->CategoryName; ?></option>
                            <?php
                            $sql2 = "SELECT * FROM tblcategory";
                            $query2 = $dbh->prepare($sql2);
                            $query2->execute();
                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                            foreach ($result2 as $row1) {
                            ?>
                                <option value="<?php echo htmlentities($row1->ID); ?>"><?php echo htmlentities($row1->CategoryName); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="scname">Subcategory Name</label>
                        <input type="text" name="scname" id="scname" value="<?php echo $row->SubcategoryName; ?>" required>
                    </div>

            <?php
                }
            }
            ?>

            <div class="form-group">
                <button type="submit" name="submit" class="btn">Update</button>
            </div>
        </form>
    </div>

</body>

</html>
<?php } ?>
