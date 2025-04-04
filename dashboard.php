<?php
session_start();
error_reporting(0);
include('db.php');

if (strlen($_SESSION['ofsmsaid'] == 0)) {
    header('location:logout.php');
} else {

    // SQL Queries to retrieve data
    $sql1 = "SELECT * FROM tblorder WHERE Status IS NULL";
    $query1 = $dbh->prepare($sql1);
    $query1->execute();
    $totneworder = $query1->rowCount();

    $sql2 = "SELECT * FROM tblorder";
    $query2 = $dbh->prepare($sql2);
    $query2->execute();
    $totorder = $query2->rowCount();

    $sql3 = "SELECT * FROM tblorder WHERE Status='Confirmed'";
    $query3 = $dbh->prepare($sql3);
    $query3->execute();
    $totconorder = $query3->rowCount();

    $sql4 = "SELECT * FROM tblproducts";
    $query4 = $dbh->prepare($sql4);
    $query4->execute();
    $totproduct = $query4->rowCount();

    $sql5 = "SELECT * FROM tblorder WHERE Status='Delivered'";
    $query5 = $dbh->prepare($sql5);
    $query5->execute();
    $totdelorder = $query5->rowCount();

    $sql6 = "SELECT * FROM tblbrand";
    $query6 = $dbh->prepare($sql6);
    $query6->execute();
    $totbrand = $query6->rowCount();

    $sql7 = "SELECT * FROM tblorder WHERE Status='Cancelled'";
    $query7 = $dbh->prepare($sql7);
    $query7->execute();
    $totcanorder = $query7->rowCount();

    $sql8 = "SELECT * FROM tbluser";
    $query8 = $dbh->prepare($sql8);
    $query8->execute();
    $totuser = $query8->rowCount();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Furniture Store Management System | Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .dashboard-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .box {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .box h3 {
            margin: 0 0 10px;
            font-size: 18px;
            color: #333;
        }

        .box p {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin: 0 0 15px;
        }

        .box a {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }

        .box a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Dashboard</h1>
        <div class="dashboard-section">
            <div class="box">
                <h3>Total New Orders</h3>
                <p><?php echo htmlentities($totneworder); ?></p>
                <a href="new-order.php">View Details</a>
            </div>

            <div class="box">
                <h3>Total Orders</h3>
                <p><?php echo htmlentities($totorder); ?></p>
                <a href="all-order.php">View Details</a>
            </div>

            <div class="box">
                <h3>Total Confirmed Orders</h3>
                <p><?php echo htmlentities($totconorder); ?></p>
                <a href="confirmed-order.php">View Details</a>
            </div>

            <div class="box">
                <h3>Total Products</h3>
                <p><?php echo htmlentities($totproduct); ?></p>
                <a href="manage-products.php">View Details</a>
            </div>

            <div class="box">
                <h3>Total Delivered Orders</h3>
                <p><?php echo htmlentities($totdelorder); ?></p>
                <a href="delivered-order.php">View Details</a>
            </div>

            <div class="box">
                <h3>Total Brands</h3>
                <p><?php echo htmlentities($totbrand); ?></p>
                <a href="manage-brand.php">View Details</a>
            </div>

            <div class="box">
                <h3>Total Cancelled Orders</h3>
                <p><?php echo htmlentities($totcanorder); ?></p>
                <a href="cancelled-order.php">View Details</a>
            </div>

            <div class="box">
                <h3>Total Users</h3>
                <p><?php echo htmlentities($totuser); ?></p>
                <a href="reg-users.php">View Details</a>
            </div>
        </div>
    </div>

</body>

</html>