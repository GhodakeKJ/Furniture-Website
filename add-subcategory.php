
<?php
session_start();
error_reporting(0);
include('db.php');
if (strlen($_SESSION['ofsmsaid']==0)) {
  header('location:logout.php');
} else {
  if(isset($_POST['submit'])) {
    $ofsmsaid=$_SESSION['ofsmsaid'];
    $catid=$_POST['cat'];
    $scname=$_POST['scname'];

    $sql="insert into tblsubcategory(CatID,SubcategoryName)values(:catid,:scname)";
    $query=$dbh->prepare($sql);
    $query->bindParam(':catid',$catid,PDO::PARAM_STR);
    $query->bindParam(':scname',$scname,PDO::PARAM_STR);
    $query->execute();

    $LastInsertId=$dbh->lastInsertId();
    if ($LastInsertId > 0) {
      echo '<script>alert("Sub Category has been added.")</script>';
      echo "<script>window.location.href ='add-subcategory.php'</script>";
    } else {
      echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
  }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD Subcategory | Furniture Store</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
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
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #5cb85c;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 16px;
        }
        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add Subcategory</h1>
        <form action="#" method="post">
            <div class="form-group">
                <label for="cat">Category Name</label>
                <select name="cat" id="cat" required>
                    <option value="">Choose Category</option>
                    <?php 
                    $sql2 = "SELECT * from tblcategory";
                    $query2 = $dbh->prepare($sql2);
                    $query2->execute();
                    $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                    foreach($result2 as $row) {
                        echo '<option value="'.htmlentities($row->ID).'">'.htmlentities($row->CategoryName).'</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="scname">Subcategory Name</label>
                <input type="text" name="scname" id="scname" required>
            </div>

            <button type="submit" name="submit">Add</button>
        </form>
    </div>
</body>
</html>
