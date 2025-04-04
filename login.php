<?php
session_start();
error_reporting(0);
include('db.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash password using md5

    // Query to check username and password in the database
    $sql = "SELECT ID FROM tbladmin WHERE UserName='$username' AND Password='$password'";
    $query = mysqli_query($con, $sql); // Execute the query using MySQLi
    $result = mysqli_fetch_assoc($query);

    if ($result) {
        $_SESSION['ofsmsaid'] = $result['ID']; // Store user ID in the session
        $_SESSION['login'] = $username; // Save username in the session
        echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Login | Online Furniture Store Management System</title>

    <!-- Internal CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .back-link {
            margin-top: 20px;
        }

        .back-link .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .back-link .btn:hover {
            background-color: #0056b3;
        }

        .custom-login {
            margin-top: 50px;
        }

        .custom-login h3 {
            font-size: 24px;
            color: #333;
        }

        .hpanel {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .btn-block {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-block:hover {
            background-color: #218838;
        }

        .text-center {
            margin-top: 20px;
            color: #007bff;
        }

        footer {
            margin-top: 50px;
            text-align: center;
            color: #007bff;
        }

        p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="back-link">
                    <a href="index.php" class="btn btn-primary">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
            <div class="col-md-4 col-md-4 col-sm-4 col-xs-12">
                <div class="text-center m-b-md custom-login">
                    <h3>PLEASE LOGIN TO OFSMS</h3>
                    <p>This is the best app ever!</p>
                </div>
                <div class="hpanel">
                    <div class="panel-body">
                        <form action="" method="post" id="login" name="login">
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" class="form-control" placeholder="Enter your username" name="username" required="true">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Enter your password" name="password" required="true">
                            </div>
                            <button class="btn btn-success btn-block" name="login" type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
        </div>
        <div class="row text-center">
            <div class="col-md-12 col-md-12 col-sm-12 col-xs-12">
                <footer>
                    <p>Online Furniture Store Management System © <?php echo date('Y'); ?></p>
                </footer>
            </div>
        </div>
    </div>
</body>
</html>
