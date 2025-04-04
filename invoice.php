
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ofsmsuid']) == 0) {
    header('location:logout.php');
} else {
    $userid = $_SESSION['ofsmsuid'];
    $oid = $_GET['odid'];

    // Fetch order details
    $sql1 = "SELECT * FROM tblorder WHERE UserID = :userid AND OrderNumber = :odid";
    $query1 = $dbh->prepare($sql1);
    $query1->bindParam(':userid', $userid, PDO::PARAM_STR);
    $query1->bindParam(':odid', $oid, PDO::PARAM_STR);
    $query1->execute();
    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);

    if ($query1->rowCount() > 0) {
        foreach ($results1 as $row1) {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Order Details</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 20px;
                    }
                    table, th, td {
                        border: 1px solid #000;
                    }
                    th, td {
                        padding: 10px;
                        text-align: left;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                    img {
                        max-width: 100%;
                        height: auto;
                    }
                    .print-button {
                        margin-top: 20px;
                        padding: 10px 20px;
                        background-color: #007bff;
                        color: #fff;
                        border: none;
                        cursor: pointer;
                    }
                    .print-button:hover {
                        background-color: #0056b3;
                    }
                </style>
            </head>
            <body>
                <div id="exampl">
                    <table>
                        <tr>
                            <th>Order Number</th>
                            <td><?php echo $_GET['odid']; ?></td>
                            <th>Order Date</th>
                            <td><?php echo $row1->OrderDate; ?></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td><?php echo $row1->FullName; ?></td>
                            <th>Contact Number</th>
                            <td><?php echo $row1->ContactNumber; ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td colspan="3">
                                <?php echo $row1->ContactNumber; ?><br>
                                <?php echo $row1->FlatNo; ?>, <?php echo $row1->StreetName; ?><br>
                                <?php echo $row1->Area; ?>, <?php echo $row1->Landmark; ?><br>
                                <?php echo $row1->City; ?>-<?php echo $row1->Zipcode; ?><br>
                                <?php echo $row1->State; ?>
                            </td>
                        </tr>
                    </table>

                    <table>
                        <thead>
                            <tr>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Order Number</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch product details
                            $sql = "SELECT tblorder.OrderNumber, tblorder.OrderDate, tblproducts.ProductTitle, tblproducts.SalePrice, tblproducts.Image, tblorderdetails.ProductId, tblorderdetails.ProductQty 
                                    FROM tblorder 
                                    JOIN tblorderdetails ON tblorderdetails.OrderNumber = tblorder.OrderNumber 
                                    JOIN tblproducts ON tblorderdetails.ProductId = tblproducts.ID 
                                    WHERE tblorder.UserID = :userid AND tblorder.OrderNumber = :odid";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':userid', $userid, PDO::PARAM_STR);
                            $query->bindParam(':odid', $oid, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                            $grandtotal = 0;
                            $gqty = 0;

                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    ?>
                                    <tr>
                                        <td><img src="admin/images/<?php echo $row->Image; ?>" alt="" width="200" height="120"></td>
                                        <td><?php echo $row->ProductTitle; ?></td>
                                        <td><?php echo $row->OrderNumber; ?></td>
                                        <td><?php echo $qty = $row->ProductQty; ?></td>
                                        <td><?php echo $total = $row->SalePrice; ?></td>
                                    </tr>
                                    <?php
                                    $grandtotal += $total;
                                    $gqty += $qty;
                                }
                            }
                            ?>
                            <tr>
                                <td colspan="3" align="right">Total:</td>
                                <td><strong><?php echo $gqty; ?></strong></td>
                                <td><strong><?php echo "Rs. " . number_format($grandtotal, 2); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button class="print-button" onclick="window.print()">Print</button>
            </body>
            </html>
            <?php
        }
    }
}
?>