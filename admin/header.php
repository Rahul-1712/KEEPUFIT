<?php

require 'partials/dbconnect.php';

// print_r($_SESSION);
// die();

if (!isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] != true) {
    header('location: adminlogin.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Panel</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    

</head>

<body>


    <nav class="navbar fixed-top">
        <h2 class="navbar-nav navbar-title">Admin Panel</h2>
        <div class="dropdown">
            <div class="navbar-user">
                <?php 
                    $username = $_SESSION['ADMIN_USERNAME'];
                    $sql = "SELECT * FROM admin_users WHERE username='$username'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                ?>
                <img src="<?php echo ADMIN_USER_IMAGE_SITE_PATH.$row['image'] ?>">

                <h5><?php echo $_SESSION['ADMIN_USERNAME']; ?><i class="fa fa-chevron-down ms-3" aria-hidden="true"></i></h5>

            </div>
            <div class="dropdown-content">
                <a href="register.php"><i class="fa fa-user-plus  fa-lg" aria-hidden="true"></i>Register Admin</a>
                <a href="#"><i class="fa fa-cog fa-lg" aria-hidden="true"></i>Setting</a>
                <a class="sign-out" href="logout.php"><i class="fa fa-sign-out fa-lg" aria-hidden="true"></i>Sign Out</a>
            </div>
        </div>
    </nav>

    <div class="main-body ">

        <div class="sidebar">
            <ul class="laptop-menu">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i>Dashboard</a></li>
                <li><a href="category.php"><i class="fa fa-tags" aria-hidden="true"></i>Category</a></li>
                <li><a href="products.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Product</a></li>
                <li><a href="orders.php"><i class="fa fa-list" aria-hidden="true"></i>Order</a></li>
                <li><a href="customer.php"><i class="fa fa-users" aria-hidden="true"></i>Customer</a</li>
                <li><a href="contact.php"><i class="fa fa-phone" aria-hidden="true"></i>Contact us</a></li>
            </ul>
        </div>
