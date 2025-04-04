
<?php
session_start();
error_reporting(0);
include('db.php');

if (strlen($_SESSION['ofsmsaid']) == 0) {
    header('location:logout.php');
} else {
    // Code for deleting product
    if (isset($_GET['delid'])) {
        $id = intval($_GET['delid']);
        $count = $dbh->prepare("DELETE FROM tblproducts WHERE ID = :id");
        $count->bindParam(":id", $id, PDO::PARAM_INT);
        $count->execute();
        echo "<script>alert('Data deleted');</script>";
        echo "<script>window.location.href ='manage-products.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products | Online Furniture Store Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            height: auto;
        }
        .action-links a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .action-links a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Furniture Products</h1>
        <table>
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Image</th>
                    <th>Product Title</th>
                    <th>MRP</th>
                    <th>Selling Price</th>
                    <th>Quantity</th>
                    <th>Stock</th>
                    <th>Setting</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM tblproducts";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                $cnt = 1;
                if ($query->rowCount() > 0) {
                    foreach ($results as $row) {
                        ?>
                        <tr>
                            <td><?php echo htmlentities($cnt); ?></td>
                            <td><img src="category images/<?php echo $row->Image; ?>" width="100" height="100" alt="<?php echo $row->ProductTitle; ?>"></td>
                            <td><?php echo htmlentities($row->ProductTitle); ?></td>
                            <td><?php echo htmlentities($row->RegularPrice); ?></td>
                            <td><?php echo htmlentities($row->SalePrice); ?></td>
                            <td><?php echo htmlentities($row->Quantity); ?></td>
                            <td><?php echo htmlentities($row->Availability); ?></td>
                            <td class="action-links">
                                <a href="edit-products-detail.php?editid=<?php echo htmlentities($row->ID); ?>">Edit</a>
                                <a href="manage-products.php?delid=<?php echo htmlentities($row->ID); ?>" onclick="return confirm('Do you really want to Delete?');">Delete</a>
                            </td>
                        </tr>
                        <?php
                        $cnt++;
                    }
                } else {
                    echo "<tr><td colspan='8' class='error-message'>No products found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php include_once('footer.php'); ?>
