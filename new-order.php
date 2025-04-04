
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ofsmsaid']) == 0) {
    header('location:logout.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Orders | Online Furniture Store Management System</title>
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
        .action-links a.view {
            background-color: #007bff;
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
                $sql = "SELECT * FROM tblorder WHERE Status IS NULL";
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
                            <td class="action-links">
                                <a href="view-order-detail.php?viewid=<?php echo htmlentities($row->OrderNumber); ?>" class="view">View</a>
                            </td>
                        </tr>
                        <?php
                        $cnt++;
                    }
                } else {
                    echo "<tr><td colspan='6' class='error-message'>No new orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php } ?>