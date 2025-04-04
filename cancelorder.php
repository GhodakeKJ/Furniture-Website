
<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');

if (strlen($_SESSION['ofsmsuid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $orderid = $_GET['oid'];
        $ressta = "Cancelled";
        $remark = $_POST['restremark'];
        $canclbyuser = 1;

        // Insert tracking details
        $sql = "INSERT INTO tbltracking (OrderId, Remark, Status, OrderCanclledByUser) 
                VALUES (:orderid, :remark, :ressta, :canclbyuser)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':orderid', $orderid, PDO::PARAM_STR);
        $query->bindParam(':remark', $remark, PDO::PARAM_STR);
        $query->bindParam(':ressta', $ressta, PDO::PARAM_STR);
        $query->bindParam(':canclbyuser', $canclbyuser, PDO::PARAM_STR);
        $query->execute();

        // Update order status
        $sql1 = "UPDATE tblorder SET Status = :ressta WHERE OrderNumber = :orderid";
        $query1 = $dbh->prepare($sql1);
        $query1->bindParam(':orderid', $orderid, PDO::PARAM_STR);
        $query1->bindParam(':ressta', $ressta, PDO::PARAM_STR);
        $query1->execute();

        echo '<script>alert("Remark has been updated.")</script>';
        echo "<script>window.location.href ='order-detail.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Cancellation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            font-size: 20px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        $orderid = $_GET['oid'];
        $sql1 = "SELECT OrderNumber, Status FROM tblorder WHERE OrderNumber = :orderid";
        $query = $dbh->prepare($sql1);
        $query->bindParam(':orderid', $orderid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        ?>

        <table>
            <tr>
                <th colspan="2">Cancel Order #<?php echo $orderid; ?></th>
            </tr>
            <tr>
                <th>Order Number</th>
                <th>Current Status</th>
            </tr>
            <?php
            if ($query->rowCount() > 0) {
                foreach ($results as $row) {
                    ?>
                    <tr>
                        <td><?php echo $orderid; ?></td>
                        <td>
                            <?php
                            $status = $row->Status;
                            if ($status == "") {
                                echo "Waiting for confirmation";
                            } else {
                                echo $status;
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>

        <?php if ($status == "" || $status == "Confirmed") { ?>
            <form method="post">
                <table>
                    <tr>
                        <th>Reason for Cancel</th>
                        <td>
                            <textarea name="restremark" rows="12" cols="50" required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <button type="submit" name="submit">Update Order</button>
                        </td>
                    </tr>
                </table>
            </form>
        <?php } else { ?>
            <?php if ($status == 'Cancelled') { ?>
                <p class="error-message">Order Cancelled</p>
            <?php } else { ?>
                <p class="error-message">You can't cancel this. Order is on the way or delivered.</p>
            <?php } ?>
        <?php } ?>
    </div>
</body>
</html>
<?php } ?>