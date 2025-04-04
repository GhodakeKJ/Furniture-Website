<?php
session_start();
// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Database connection
require_once 'db.php';

// Get admin data
$admin_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Furniture Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar .nav-link {
            color: #333;
        }
        .sidebar .nav-link:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="p-3">
                    <h4>Furniture Shop Admin</h4>
                    <hr>
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="#dashboard">Dashboard</a>
                        <a class="nav-link" href="#products">Products</a>
                        <a class="nav-link" href="#orders">Orders</a>
                        <a class="nav-link" href="#customers">Customers</a>
                        <a class="nav-link" href="#categories">Categories</a>
                        <a class="nav-link" href="logout.php">Logout</a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ml-sm-auto">
                <div class="p-4">
                    <h2>Admin Dashboard</h2>
                    <hr>

                    <!-- Dashboard Stats -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Total Products</h5>
                                    <?php
                                    $stmt = $conn->prepare("SELECT COUNT(*) FROM products");
                                    $stmt->execute();
                                    echo "<h3>" . $stmt->get_result()->fetch_row()[0] . "</h3>";
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-success">
                                <div class="card-body">
                                    <h5 class="card-title">Total Orders</h5>
                                    <?php
                                    $stmt = $conn->prepare("SELECT COUNT(*) FROM orders");
                                    $stmt->execute();
                                    echo "<h3>" . $stmt->get_result()->fetch_row()[0] . "</h3>";
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- Add more stats cards -->
                    </div>

                    <!-- Recent Orders -->
                    <div class="card mb-4">
                        <div class="card-header">
                            Recent Orders
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM orders ORDER BY order_date DESC LIMIT 5");
                                    $stmt->execute();
                                    $orders = $stmt->get_result();
                                    
                                    while ($order = $orders->fetch_assoc()) {
                                        echo "<tr>
                                                <td>#" . $order['id'] . "</td>
                                                <td>" . $order['customer_name'] . "</td>
                                                <td>$" . $order['total_amount'] . "</td>
                                                <td>" . $order['status'] . "</td>
                                                <td>
                                                    <a href='view-order.php?id=" . $order['id'] . "' class='btn btn-sm btn-info'>View</a>
                                                </td>
                                            </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>