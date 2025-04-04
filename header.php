<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title> Furniture House </title>
  <meta charset="utf-8">
  <style>
   /* General Styles */
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f9f9f9; /* Light gray background */
}

.main_wrapper {
  width: 100%;
  margin: 0 auto;
  background-color: #fff; /* White background for the main container */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

/* Header Styles */
.header_wrapper {
  background-color: #fff; /* White background for the header */
  color: #333; /* Dark text color */
  padding: 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #e0e0e0; /* Light gray border for separation */
}

.header_wrapper img {
  margin: 5px;
}

/* Navigation Bar Styles */
#navbar {
  background-color: #fff; /* White background for the navbar */
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  border-bottom: 1px solid #e0e0e0; /* Light gray border for separation */
}

#navbar ul#menu {
  list-style-type: none;
  margin: 0;
  padding: 0;
  display: flex;  /* Flex for better alignment */
}

#navbar ul#menu li {
  margin-right: 20px;  /* Space between menu items */
}

#navbar ul#menu li a {
  color: #333; /* Dark text color */
  text-decoration: none;
  padding: 8px 16px;
  display: inline-block;
  transition: background-color 0.3s ease; /* Smooth hover transition */
}

#navbar ul#menu li a:hover {
  background-color: #f0f0f0; /* Light gray background on hover */
  border-radius: 4px;
}

/* Search Form Styles */
#form {
  display: flex;  /* Use flexbox to keep form aligned */
  align-items: center;
}

#form input[type="text"] {
  padding: 8px;
  border: 1px solid #e0e0e0; /* Light gray border */
  border-radius: 4px;
  background-color: #fff; /* White background */
}

#form input[type="submit"] {
  padding: 8px 12px;
  background-color: #5cb85c; /* Green button */
  border: none;
  color: white;
  border-radius: 4px;
  cursor: pointer;
  margin-left: 5px; /* Space between text input and button */
  transition: background-color 0.3s ease; /* Smooth hover transition */
}

#form input[type="submit"]:hover {
  background-color: #4cae4c; /* Darker green on hover */
}

/* Login/Logout Link Styles */
#log_user {
  margin-left: 10px;
}

#log_user a {
  color: white;
  text-decoration: none;
  padding: 8px 16px;
  background-color: #0275d8; /* Blue button */
  border-radius: 4px;
  transition: background-color 0.3s ease; /* Smooth hover transition */
}

#log_user a:hover {
  background-color: #025aa5; /* Darker blue on hover */
}

  </style>
</head>

<body>
  <!--Main Container starts -->
  <div class="main_wrapper">

    <!--Header Starts from here-->
    <div class="header_wrapper">
      <a href="index.php"><img src="furniture images\logo.jpg" width="200px" height="100px" style="float:left"></a>
      <img src="furniture images\ad_banner.jpg" width="800px" height="100px" style="float:right">
    </div>
    <!--Header ends here-->

    <!--Navigation Bar starts -->
    <div id="navbar">
      <ul id="menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="category-details.php">Furniture</a></li>
        <?php
        if (!isset($_SESSION['customer_email'])) {
          echo "<li><a href='customer_register.php'>Sign up</a></li>";
        } else {
          echo "<li><a href='customer/my_account.php'>My Account</a></li>";
        }
        ?>
        <li><a href="cart.php">Shopping Cart</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="login.php">Admin</a></li>
      </ul>

      <div id="form">
        <form method="get" action="results.php" enctype="multipart/form-data">
          <input type="text" name="user_query" placeholder="Search a Product">
          <input type="submit" name="search" value="Search">
        </form>
      </div>

      <div id="log_user">
        <?php
        if (!isset($_SESSION['customer_email'])) {
          echo "<a href='signup.php'>Login</a>";
        } else {
          echo "<a href='logout.php'>Logout</a>";
        }
        ?>
      </div>
    </div>
    <!--Navigation Bar ends -->

  </div>
  <!--Main Container ends -->
</body>
</html>