<?php
session_start();
error_reporting(0);
include('db.php');
if (strlen($_SESSION['ofsmsaid'] == 0)) {
    header('location:logout.php');
} else {
?>
<!doctype html>
<html lang="en">

<head>
    <title>Online Furniture Store Management System | New Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            color: white;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #333;
            color: white;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>New Furniture Orders</h1>

        <table>
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Order Number</th>
                    <th>Full Name</th>
                    <th>Contact Number</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * from tblorder where Status is null";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            $cnt = 1;
            if ($query->rowCount() > 0) {
                foreach ($results as $row) {
            ?>   
                <tr>
                    <td><?php echo htmlentities($cnt); ?></td>
                    <td><?php echo htmlentities($row->OrderNumber); ?></td>
                    <td><?php echo htmlentities($row->FullName); ?></td>
                    <td><?php echo htmlentities($row->ContactNumber); ?></td>
                    <td><?php echo htmlentities($row->OrderDate); ?></td>
                    <td><a href="view-order-detail.php?viewid=<?php echo htmlentities($row->OrderNumber); ?>" class="btn">View</a></td>
                </tr>
            <?php 
                $cnt++;
                }
            } 
            ?>
            </tbody>
        </table>
    </div>

    <footer>
        <?php include_once('includes/footer.php'); ?>
    </footer>
</body>

</html>
<?php
}
?>
