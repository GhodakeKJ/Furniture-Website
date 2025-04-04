
<?php
session_start();
error_reporting(0);
include('db.php');
if (strlen($_SESSION['ofsmsaid'] == 0)) {
  header('location:l.php');
} else {
  if ($_GET['id']) {
    $id = $_GET['id'];
    $query = $dbh->prepare("DELETE FROM tbluser WHERE ID='$id'");
    $query->execute();
    $ret = $dbh->prepare("DELETE FROM tblorder WHERE UserID='$id'");
    $ret->execute();
    echo "<script>alert('User Deleted');</script>";
    echo "<script>window.location.href='reg-users.php'</script>";
  }
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Furniture Store Management System | Registered Users</title>
    <link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet">
    <style>
        body {
            font-family: 'Play', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .btn {
            padding: 8px 16px;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .alert {
            padding: 12px;
            background-color: #f44336;
            color: white;
            margin-bottom: 20px;
        }

    </style>
</head>

<body>
    <div class="container">
        <h1>Registered Users</h1>

        <table>
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Name</th>
                    <th>Mobile Number</th>
                    <th>Email</th>
                    <th>Reg Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * from tbluser";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                $cnt = 1;
                if ($query->rowCount() > 0) {
                  foreach ($results as $row) {
                ?>   
                    <tr>
                        <td><?php echo htmlentities($cnt); ?></td>
                        <td><?php echo htmlentities($row->FullName); ?></td>
                        <td><?php echo htmlentities($row->MobileNumber); ?></td>
                        <td><?php echo htmlentities($row->Email); ?></td>
                        <td><?php echo htmlentities($row->RegDate); ?></td>
                        <td>
                            <a href="reg-users.php?id=<?php echo htmlentities($row->ID); ?>" class="btn btn-danger" onClick="return confirm('User profile and all orders related to this user will be deleted')">Delete</a>
                            <a href="user-orders.php?userid=<?php echo htmlentities($row->ID); ?>&&username=<?php echo htmlentities($row->FullName); ?>" class="btn">Orders</a>
                        </td>
                    </tr>
                <?php $cnt = $cnt + 1; }} ?>
            </tbody>
        </table>
    </div>
</body>

</html>
<?php } ?>
