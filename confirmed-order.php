
<?php
session_start();
error_reporting(0);
include('db.php');
if (strlen($_SESSION['ofsmsaid'] == 0)) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Furniture Store Management System | Confirmed Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .sidebar {
            width: 250px;
            background-color: #333;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 0;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        .header {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>


    <!-- Main Content -->
    <div class="main-content">
        <?php include_once('header.php'); ?>

        <div class="container">
            <h1>Confirmed Furniture Orders</h1>

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
                $sql = "SELECT * from tblorder where Status='Confirmed'";
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
                        $cnt = $cnt + 1;
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <?php include_once('footer.php'); ?>
    </div>
</body>
</html>
<?php } ?>
