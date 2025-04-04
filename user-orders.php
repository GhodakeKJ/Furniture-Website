<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ofsmsaid']) == 0) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Furniture Store Management System | New Orders</title>
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
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .btn {
            padding: 8px 12px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        .sidebar {
            width: 200px;
            background-color: #333;
            color: #fff;
            padding: 20px;
            position: fixed;
            height: 100%;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }
        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <?php include_once('includes/sidebar.php');?>
    </div>
    <div class="content">
        <div class="header">
            <h1>Online Furniture Store Management System</h1>
        </div>
        <div class="container">
            <h1><?php echo $_GET['username']?>'s <span>Orders</span></h1>
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
                    $uid = intval($_GET['userid']);
                    $sql = "SELECT * FROM tblorder WHERE UserID='$uid'";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    $cnt = 1;
                    if ($query->rowCount() > 0) {
                        foreach ($results as $row) {
                    ?>
                    <tr>
                        <td><?php echo htmlentities($cnt);?></td>
                        <td><?php echo htmlentities($row->OrderNumber);?></td>
                        <td><?php echo htmlentities($row->FullName);?></td>
                        <td><?php echo htmlentities($row->ContactNumber);?></td>
                        <td><?php echo htmlentities($row->OrderDate);?></td>
                        <td><a href="view-order-detail.php?viewid=<?php echo htmlentities($row->OrderNumber);?>" class="btn">View</a></td>
                    </tr>
                    <?php
                            $cnt = $cnt + 1;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="footer">
            <?php include_once('includes/footer.php');?>
        </div>
    </div>
</body>

</html>
<?php } ?>