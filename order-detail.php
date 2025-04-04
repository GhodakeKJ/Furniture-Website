
<?php
session_start();
if (strlen($_SESSION['ofsmsuid'] == 0)) {
    header('location:logout.php');
} else {
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Online Furniture Store Management System::Order Detail Page</title>

<style>
/* Internal CSS for styling */
body {
    font-family: 'Montserrat', sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

h2 {
    text-align: center;
    color: #333;
}

.breadcrumb {
    background-color: #e9ecef;
    padding: 10px;
    border-radius: 5px;
    list-style: none;
    display: flex;
}

.breadcrumb li {
    margin-right: 10px;
}

.breadcrumb li a {
    text-decoration: none;
    color: #007bff;
}

.breadcrumb li.active {
    color: #6c757d;
}

.table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 10px;
    border: 1px solid #dee2e6;
    text-align: left;
}

.table th {
    background-color: #f1f1f1;
}

.table img {
    width: 200px;
    height: 120px;
    object-fit: cover;
}

.total-row {
    text-align: right;
    font-weight: bold;
}

footer {
    text-align: center;
    padding: 20px;
    background-color: #f1f1f1;
    margin-top: 20px;
    border-radius: 0 0 10px 10px;
}
</style>

<script language="javascript" type="text/javascript">
var popUpWin = 0;
function popUpWindow(URLStr, left, top, width, height) {
    if (popUpWin) {
        if (!popUpWin.closed) popUpWin.close();
    }
    popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 700 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
}
</script>

</head>
<body>

<!-- header -->
<div class="container">
    <h2>Order Details</h2>

    <ol class="breadcrumb">
        <li><a href="men.html">Home</a></li>
        <li class="active">My Order</li>
    </ol>
    
    <strong style="color: red">Order #12345 Details</strong>
    
    <p><b>Order Date:</b> 2025-03-12</p>
    <p><b>Payment Type:</b> Credit Card</p>
    <p><b>Order Status:</b> Waiting for confirmation 
        &nbsp;(<a href="javascript:void(0);" onClick="popUpWindow('trackorder.php?odid=12345');" style="color:#000">Track order</a>)
    </p>
    <a href="javascript:void(0);" onClick="popUpWindow('invoice.php?odid=12345');" style="color:red; font-weight:bold;">Invoice</a>

    <table class="table">
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
            <tr>
                <td><img src="admin/images/sample-product.jpg" alt="Product Image"></td>
                <td>Wooden Chair</td>
                <td>12345</td>
                <td>2</td>
                <td>Rs. 5,000</td>
            </tr>
            <tr>
                <td><img src="admin/images/sample-product2.jpg" alt="Product Image"></td>
                <td>Glass Table</td>
                <td>12345</td>
                <td>1</td>
                <td>Rs. 8,000</td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" align="right">Total Quantity:</td>
                <td>3</td>
                <td>Total: Rs. 13,000</td>
            </tr>
        </tfoot>
    </table>

    <p style="color:red;padding-bottom: 20px">
        <a href="javascript:void(0);" onClick="popUpWindow('cancelorder.php?oid=12345');" style="color:red">Cancel this order</a>
    </p>
</div>

<footer>
    <p>Online Furniture Store Management System © 2025</p>
</footer>

</body>
</html>

<?php } ?>
