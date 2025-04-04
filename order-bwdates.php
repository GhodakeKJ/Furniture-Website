
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ofsmsaid']) == 0) {
    header('location:logout.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Between Dates Report | Online Furniture Store Management System</title>
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
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }
        .col-3, .col-9 {
            padding: 0 15px;
            box-sizing: border-box;
        }
        .col-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }
        .col-9 {
            flex: 0 0 75%;
            max-width: 75%;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Between Dates Report</h1>
        <form action="order-bwdates-reports-details.php" method="post">
            <div class="form-group">
                <div class="row">
                    <div class="col-3">
                        <label for="fromdate">From Date:</label>
                    </div>
                    <div class="col-9">
                        <input type="date" name="fromdate" id="fromdate" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-3">
                        <label for="todate">To Date:</label>
                    </div>
                    <div class="col-9">
                        <input type="date" name="todate" id="todate" required>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" name="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php } ?>