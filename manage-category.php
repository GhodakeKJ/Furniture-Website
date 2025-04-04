
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ofsmsaid']) == 0) {
    header('location:logout.php');
} else {
    // Code for deleting category
    if ($_GET['id']) {
        $id = $_GET['id'];
        $query = $dbh->prepare("DELETE FROM tblcategory WHERE ID = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        echo "<script>alert('Category Deleted');</script>";
        echo "<script>window.location.href='manage-category.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Category | Online Furniture Store Management System</title>
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
        .action-links a {
            margin-right: 10px;
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .action-links a.edit {
            background-color: #007bff;
        }
        .action-links a.delete {
            background-color: #dc3545;
        }
        .action-links a:hover {
            opacity: 0.8;
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
        <h1>Manage Category</h1>
        <table>
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Category Name</th>
                    <th>Creation Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM tblcategory";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                $cnt = 1;
                if ($query->rowCount() > 0) {
                    foreach ($results as $row) {
                        ?>
                        <tr>
                            <td><?php echo htmlentities($cnt); ?></td>
                            <td><?php echo htmlentities($row->CategoryName); ?></td>
                            <td><?php echo htmlentities($row->CreationDate); ?></td>
                            <td class="action-links">
                                <a href="edit-category-detail.php?editid=<?php echo htmlentities($row->ID); ?>" class="edit">Edit</a>
                                <a href="manage-category.php?id=<?php echo htmlentities($row->ID); ?>" class="delete" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                            </td>
                        </tr>
                        <?php
                        $cnt++;
                    }
                } else {
                    echo "<tr><td colspan='4' class='error-message'>No categories found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php } ?>