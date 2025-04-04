<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if the user is logged in
if (strlen($_SESSION['ofsmsaid']) == 0) {
    header('location:logout.php');
    exit();
}

// Handle form submission
if (isset($_POST['submit'])) {
    $vid = $_GET['viewid'];
    $status = $_POST['status'];
    $remark = $_POST['remark'];

    // Insert tracking details
    $sql = "INSERT INTO tbltracking (OrderId, Remark, Status) VALUES (:vid, :remark, :status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':vid', $vid, PDO::PARAM_STR);
    $query->bindParam(':remark', $remark, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();

    // Update order status
    $sql1 = "UPDATE tblorder SET Status = :status WHERE OrderNumber = :vid";
    $query1 = $dbh->prepare($sql1);
    $query1->bindParam(':vid', $vid, PDO::PARAM_STR);
    $query1->bindParam(':status', $status, PDO::PARAM_STR);
    $query1->execute();

    echo '<script>alert("Remark has been updated")</script>';
    echo "<script>window.location.href ='all-order.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Brand | Online Furniture Store Management System</title>
    <style>
        /* Internal CSS for Styling */
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
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <?php include_once('includes/sidebar.php'); ?>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Header -->
        <div class="header">
            <h1>Online Furniture Store Management System</h1>
        </div>

        <!-- Container for Table -->
        <div class="container">
            <h1>View Order Details</h1>
            <?php
            $vid = $_GET['viewid'];
            $sql1 = "SELECT tblorder.payType, tblorder.OrderNumber, tblorder.OrderDate, tblorder.FullName, tblorder.ContactNumber, tblorder.FlatNo, tblorder.StreetName, tblorder.Area, tblorder.Landmark, tblorder.City, tblorder.Zipcode, tblorder.State, tblorder.Status, tbluser.FullName as afname, tbluser.MobileNumber, tbluser.Email 
                     FROM tblorder 
                     JOIN tbluser ON tbluser.ID = tblorder.UserID 
                     WHERE tblorder.OrderNumber = :vid";
            $query1 = $dbh->prepare($sql1);
            $query1->bindParam(':vid', $vid, PDO::PARAM_STR);
            $query1->execute();
            $results1 = $query1->fetchAll(PDO::FETCH_OBJ);

            if ($query1->rowCount() > 0) {
                foreach ($results1 as $row1) {
            ?>
            <table>
                <tr>
                    <td colspan="6" style="font-size:20px;color:blue">Customer Details</td>
                </tr>
                <tr>
                    <th>Order Number</th>
                    <td><?php echo htmlentities($row1->OrderNumber); ?></td>
                    <th>Full Name</th>
                    <td><?php echo htmlentities($row1->FullName); ?></td>
                    <th>Contact Number</th>
                    <td><?php echo htmlentities($row1->ContactNumber); ?></td>
                </tr>
                <tr>
                    <th>Payment Type</th>
                    <td colspan="5"><?php echo htmlentities($row1->payType); ?></td>
                </tr>
                <tr>
                    <td colspan="6" style="font-size:20px;color:blue">Delivery Address</td>
                </tr>
                <tr>
                    <th>Flat Number</th>
                    <td><?php echo htmlentities($row1->FlatNo); ?></td>
                    <th>Street Name</th>
                    <td><?php echo htmlentities($row1->StreetName); ?></td>
                    <th>Area</th>
                    <td><?php echo htmlentities($row1->Area); ?></td>
                </tr>
                <tr>
                    <th>Landmark</th>
                    <td><?php echo htmlentities($row1->Landmark); ?></td>
                    <th>City</th>
                    <td><?php echo htmlentities($row1->City); ?></td>
                    <th>Zipcode</th>
                    <td><?php echo htmlentities($row1->Zipcode); ?></td>
                </tr>
                <tr>
                    <th>State</th>
                    <td><?php echo htmlentities($row1->State); ?></td>
                    <th>Order Date</th>
                    <td><?php echo htmlentities($row1->OrderDate); ?></td>
                    <th>Order Final Status</th>
                    <td colspan="4">
                        <?php
                        $status = $row1->Status;
                        if ($status == "Confirmed") {
                            echo "Your Order has been Confirmed";
                        } elseif ($status == "On The Way") {
                            echo "Your product is on the way";
                        } elseif ($status == "Delivered") {
                            echo "Your product has been Delivered";
                        } elseif ($status == "Cancelled") {
                            echo "Your order has been cancelled";
                        } else {
                            echo "Not Response Yet";
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <?php
                }
            }
            ?>

            <!-- Item Purchased Table -->
            <table>
                <tr>
                    <td colspan="6" style="font-size:20px;color:blue">Item Purchased</td>
                </tr>
                <tr>
                    <th>S.NO</th>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Order Number</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
                <?php
                $sql = "SELECT tblorder.OrderNumber, tblorder.OrderDate, tblproducts.ProductTitle, tblproducts.SalePrice, tblproducts.Image, tblorderdetails.ProductId, tblorderdetails.ProductQty 
                        FROM tblorder 
                        JOIN tblorderdetails ON tblorderdetails.OrderNumber = tblorder.OrderNumber 
                        JOIN tblproducts ON tblorderdetails.ProductId = tblproducts.ID 
                        WHERE tblorder.OrderNumber = :vid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':vid', $vid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                $grandtotal = 0;
                $gqty = 0;

                if ($query->rowCount() > 0) {
                    foreach ($results as $row) {
                ?>
                <tr>
                    <td><?php echo htmlentities($cnt); ?></td>
                    <td><img src="images/<?php echo htmlentities($row->Image); ?>" alt="" width="80" height="80"></td>
                    <td><?php echo htmlentities($row->ProductTitle); ?></td>
                    <td><?php echo htmlentities($row->OrderNumber); ?></td>
                    <td><?php echo htmlentities($row->ProductQty); ?></td>
                    <td><?php echo "Rs. " . number_format($row->SalePrice, 2); ?></td>
                </tr>
                <?php
                        $grandtotal += $row->SalePrice;
                        $gqty += $row->ProductQty;
                        $cnt++;
                    }
                }
                ?>
                <tr>
                    <td colspan="4" align="right">Total:</td>
                    <td><strong><?php echo $gqty; ?></strong></td>
                    <td><strong><?php echo "Rs. " . number_format($grandtotal, 2); ?></strong></td>
                </tr>
            </table>

            <!-- Tracking History -->
            <?php
            if ($status != "") {
                $ret = "SELECT tbltracking.OrderCanclledByUser, tbltracking.Remark, tbltracking.Status as astatus, tbltracking.StatusDate 
                        FROM tbltracking 
                        WHERE tbltracking.OrderId = :vid";
                $query3 = $dbh->prepare($ret);
                $query3->bindParam(':vid', $vid, PDO::PARAM_STR);
                $query3->execute();
                $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
            ?>
            <table>
                <tr align="center">
                    <th colspan="4" style="color: blue">Tracking History</th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>Remark</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>
                <?php
                foreach ($results3 as $row3) {
                ?>
                <tr>
                    <td><?php echo $cnt; ?></td>
                    <td><?php echo htmlentities($row3->Remark); ?></td>
                    <td><?php echo htmlentities($row3->astatus); ?></td>
                    <td><?php echo htmlentities($row3->StatusDate); ?></td>
                </tr>
                <?php
                    $cnt++;
                }
                ?>
            </table>
            <?php
            }
            ?>

            <!-- Take Action Button -->
            <?php
            if ($status == "" || $status == "Confirmed" || $status == "On The Way") {
            ?>
            <p align="center" style="padding-top: 20px">
                <button class="btn" onclick="openModal()">Take Action</button>
            </p>
            <?php
            }
            ?>

            <!-- Modal for Take Action -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2>Take Action</h2>
                    <form method="post" name="submit">
                        <table>
                            <tr>
                                <th>Remark:</th>
                                <td>
                                    <textarea name="remark" placeholder="Remark" rows="12" cols="14" required></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <select name="status" required>
                                        <option value="Confirmed" selected>Confirmed</option>
                                        <option value="On The Way">On The Way</option>
                                        <option value="Delivered">Delivered</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <div class="modal-footer">
                            <button type="button" class="btn" onclick="closeModal()">Close</button>
                            <button type="submit" name="submit" class="btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>

    <script>
        // JavaScript for Modal
        function openModal() {
            document.getElementById('myModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }
    </script>
</body>

</html>