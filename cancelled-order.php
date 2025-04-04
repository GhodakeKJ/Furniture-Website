
<?php
session_start();
error_reporting(0);
include('db.php');
if (strlen($_SESSION['ofsmsaid']==0)) {
    header('location:logout.php');
} else{
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelled Orders | Online Furniture Store Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .header, .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Online Furniture Store Management System</h2>
    </div>

    <div class="container">
        <h1>Cancelled Furniture Orders</h1>
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
                $sql = "SELECT * from tblorder where Status='Cancelled'";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                $cnt = 1;
                if ($query->rowCount() > 0) {
                    foreach ($results as $row) { ?>   
                        <tr>
                            <td><?php echo htmlentities($cnt); ?></td>
                            <td><?php echo htmlentities($row->OrderNumber); ?></td>
                            <td><?php echo htmlentities($row->FullName); ?></td>
                            <td><?php echo htmlentities($row->ContactNumber); ?></td>
                            <td><?php echo htmlentities($row->OrderDate); ?></td>
                            <td><a href="view-order-detail.php?viewid=<?php echo htmlentities($row->OrderNumber); ?>" class="btn">View</a></td>
                        </tr>
                    <?php $cnt = $cnt + 1; 
                    }
                } ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>© 2025 Online Furniture Store Management System</p>
    </div>

</body>

</html>
<?php } ?>
