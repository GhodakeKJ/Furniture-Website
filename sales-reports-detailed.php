
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ofsmsaid']) == 0) {
    header('location:logout.php');
}

$fdate = $_POST['fromdate'];
$tdate = $_POST['todate'];
$rtype = $_POST['requesttype'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report | Online Furniture Store Management System</title>
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
        h1, h4 {
            text-align: center;
            color: #333;
        }
        h4 {
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
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($rtype == 'mtwise') {
            $month1 = strtotime($fdate);
            $month2 = strtotime($tdate);
            $m1 = date("F", $month1);
            $m2 = date("F", $month2);
            $y1 = date("Y", $month1);
            $y2 = date("Y", $month2);
            echo "<h1>Sales Report Month Wise</h1>";
            echo "<h4>Sales Report from $m1-$y1 to $m2-$y2</h4>";
        } else {
            $year1 = strtotime($fdate);
            $year2 = strtotime($tdate);
            $y1 = date("Y", $year1);
            $y2 = date("Y", $year2);
            echo "<h1>Sales Report Year Wise</h1>";
            echo "<h4>Sales Report from $y1 to $y2</h4>";
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th><?php echo ($rtype == 'mtwise') ? 'Month / Year' : 'Year'; ?></th>
                    <th>Sales</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($rtype == 'mtwise') {
                    $sql = "SELECT month(tblorderdetails.OrderDate) as lmonth, year(tblorderdetails.OrderDate) as lyear, 
                            sum(tblproducts.SalePrice * tblorderdetails.ProductQty) as totalprice 
                            FROM tblorder 
                            JOIN tblorderdetails ON tblorderdetails.OrderNumber = tblorder.OrderNumber 
                            JOIN tblproducts ON tblorderdetails.ProductId = tblproducts.ID 
                            WHERE date(tblorderdetails.OrderDate) BETWEEN :fdate AND :tdate 
                            AND (tblorder.Status = 'Delivered' OR tblorder.Status = 'On The Way' OR tblorder.Status = 'Confirmed') 
                            GROUP BY lmonth, lyear";
                } else {
                    $sql = "SELECT year(tblorderdetails.OrderDate) as lyear, 
                            sum(tblproducts.SalePrice * tblorderdetails.ProductQty) as totalprice 
                            FROM tblorder 
                            JOIN tblorderdetails ON tblorderdetails.OrderNumber = tblorder.OrderNumber 
                            JOIN tblproducts ON tblorderdetails.ProductId = tblproducts.ID 
                            WHERE date(tblorderdetails.OrderDate) BETWEEN :fdate AND :tdate 
                            AND (tblorder.Status = 'Delivered' OR tblorder.Status = 'On The Way' OR tblorder.Status = 'Confirmed') 
                            GROUP BY lyear";
                }

                $query = $dbh->prepare($sql);
                $query->bindParam(':fdate', $fdate, PDO::PARAM_STR);
                $query->bindParam(':tdate', $tdate, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                $cnt = 1;
                $ftotal = 0;

                if ($query->rowCount() > 0) {
                    foreach ($results as $row) {
                        $total = $row->totalprice;
                        $ftotal += $total;
                        ?>
                        <tr>
                            <td><?php echo $cnt; ?></td>
                            <td><?php echo ($rtype == 'mtwise') ? $row->lmonth . "/" . $row->lyear : $row->lyear; ?></td>
                            <td><?php echo $total; ?></td>
                        </tr>
                        <?php
                        $cnt++;
                    }
                    ?>
                    <tr class="total-row">
                        <td colspan="2" align="center">Total</td>
                        <td><?php echo $ftotal; ?></td>
                    </tr>
                    <?php
                } else {
                    echo "<tr><td colspan='3' align='center'>No sales data found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php } ?>