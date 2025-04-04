
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ofsmsaid']) == 0) {
    header('location:logout.php');
}

$fdate = $_POST['fromdate'];
$tdate = $_POST['todate'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Between Dates Reports | Online Furniture Store Management System</title>
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
        h4 {
            text-align: center;
            color: #333;
        }
        h5 {
            text-align: center;
            color: blue;
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
        <h1>Between Dates Reports</h1>
        <h5>Report from <?php echo $fdate; ?> to <?php echo $tdate; ?></h5>
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
                $sql = "SELECT * FROM tblorder WHERE date(OrderDate) BETWEEN :fdate AND :tdate";
                $query = $dbh->prepare($sql);
                $query->bindParam(':fdate', $fdate, PDO::PARAM_STR);
                $query->bindParam(':tdate', $tdate, PDO::PARAM_STR);
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
                                <a href="view-order-detail.php?viewid=<?php echo htmlentities($row->OrderNumber); ?>">View Details</a>
                            </td>
                        </tr>
                        <?php
                        $cnt++;
                    }
                } else {
                    echo "<tr><td colspan='6' class='error-message'>No orders found between the selected dates.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php } ?>