<?php

require 'partials/_dbconnect.php';
require 'functions.php';

$logged = false;
$user_id = '';

if (isset($_SESSION['USER_LOGGED']) && $_SESSION['USER_LOGGED'] == 'true') {
    $user_id = $_SESSION['USER_ID'];
    $logged = true;
}


// cart & wishlist_count
$cart_class = new cart();
$cart_item_count = $cart_class->totalProduct();

$wishlist_class = new Wishlist();
$wishlist_item_count = $wishlist_class->totalProduct($conn, $user_id, '');


// meta title 
$script_name = $_SERVER['SCRIPT_NAME'];
$script_name_arr = explode('/', $script_name);
$current_page = $script_name_arr[count($script_name_arr) - 1];
$current_page_arr = explode('.', $current_page);

$meta_title = $current_page_arr[0];
$meta_desc = '';
$meta_keywords = '';


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>KEEPUFIT - <?php echo $meta_title ?></title>
    <meta name="description" content="<?php echo $meta_desc ?>">
    <meta name="keywords" content="<?php echo $meta_keywords ?>" />

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/site.webmanifest">


    <!-- All css files are included here. -->
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">


    <!-- Theme main style -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Header and Footer styles -->
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">

    <!-- login ssignup css-->
    <link rel="stylesheet" href="assets/css/login_signup.css">

</head>

<body>
    <!-- Main body starts here -->

    <div class="wrapper">
        <!-- Start header -->
        <header class="header" id="sticky_header">
            <div class="mycontainer">
                <!-- main header -->
                <div class="main_header clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="logo">
                            <a href="<?php echo SITE_ROOT_PATH; ?>">
                                <img class="logo-img" src="assets/logo/logo1.png" alt="logo image">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="header_right">
                            <div class="header_search search_open">
                                <a href="#">
                                    <i class="fa fa-search icons search_icon"><span>Search</span></i>
                                </a>
                            </div>

                            <div class="header_user_account">
                                <a href="#">
                                    <i class="fa fa-user icons user_icon"><span>Account</span></i>
                                </a>
                                <!-- User icon dropdown -->
                                <!--  starts here  -->
                                <div class="user_icon_dropdown_area">
                                    <div class="dropdown_account_area">
                                        <?php
                                        if (!$logged) {
                                        ?>
                                            <a href="login.php" class="login_btn">Login</a>
                                            <a href="signup.php" class="signup_btn">SignUp</a>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="profile.php" class="dropdown_account_item"><i class="fa fa-user" aria-hidden="true"></i>User Profile</a>
                                            <a href="orders.php" class="dropdown_account_item"><i class="fa fa-list-alt" aria-hidden="true"></i>My Orders</a>
                                            <a href="logout.php" class="dropdown_account_item"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                                <!-- ends here -->
                            </div>
                            <?php
                            if ($logged) {
                            ?>
                                <div class="header_wishlist">
                                    <a href="wishlist.php">
                                        <i class="fa fa-shopping-bag icons wishlist_icon"><span>Wishlist</span></i>
                                        <div class="wishlist_item_count">
                                            <span><?php echo $wishlist_item_count; ?></span>
                                        </div>

                                    </a>
                                </div>
                            <?php
                            }
                            ?>

                            <div class="header_cart">
                                <a href="cart.php">
                                    <i class="fa fa-shopping-cart icons cart_icon"><span>Cart</span></i>
                                    <div class="cart_item_count">
                                        <span><?php echo $cart_item_count; ?></span>
                                    </div>
                                </a>
                                <!-- User icon dropdown -->
                                <!--  starts here  -->
                                <div class="cart_icon_dropdown_area">
                                    <div class="dropdown_button_area">
                                        <a href="cart.php" class="cart_btn"><span>View cart</span></a>
                                        <p><?php echo $cart_item_count; ?> items</p>
                                    </div>
                                    <div class="dropdown_product_area">
                                        <ul>
                                            <?php
                                            $subtotal = 0;
                                            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                                                foreach ($_SESSION['cart'] as $key => $value) {
                                                    $getproduct = getProducts($conn, '', '', $key, '', '', '');
                                                    $price = $getproduct[0]['price'];
                                                    $qty = $value['qty'];
                                                    $total = $price * $qty;
                                                    $subtotal = $subtotal + $total;


                                            ?>
                                                    <li>
                                                        <a href="product.php">
                                                            <div class="header_cart_product">
                                                                <div class="header_cart_product_image">
                                                                    <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $getproduct[0]['image'] ?>" alt="product image">
                                                                </div>
                                                                <div class="header_cart_product_details">
                                                                    <span class="header_cart_product_name"><?php echo $getproduct[0]['name'] ?></span>
                                                                    <span class="header_cart_quantity">Quantity : <?php echo $value['qty'] ?></span>
                                                                    <span class="header_cart_price">&#8377;<?php echo $getproduct[0]['price'] ?></span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                <?php

                                                }
                                            } else {
                                                ?>
                                                <h3>No Product in cart</h3>
                                            <?php
                                            }
                                            ?>

                                        </ul>
                                    </div>
                                    <div class="dropdown_total_area">
                                        <div class="header_total_price">
                                            <span>Subtotal:</span>
                                            <span>&#8377;<?php echo $subtotal ?></span>
                                        </div>
                                        <a href="checkout.php" class="cart_btn"><span>Checkout</span></a>

                                    </div>
                                </div>
                                <!-- ends here -->
                            </div>
                            <div class="mobile_menu_bar mobile-menu_open">
                                <a href="">
                                    <i class="fa fa-bars icons menu_icon"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- category menu -->
            <div class="cat_menu">
                <div class="mycontainer">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ul class="cat_menu_list">
                            <li class=cat_menu_main_category>
                                <a href="<?php echo SITE_ROOT_PATH; ?>" class="main_cat_link">Home</a>
                            </li>
                            <!-- <li class=cat_menu_main_category>
                                <a href="" class="main_cat_link">Clothing</a>
                                <div class="category_dropdown">
                                    <ul>
                                        <li class="dropdown_subcategory">
                                            <h4><a href="#">Mens clothing</a></h4>
                                            <ul class="items">
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown_subcategory">
                                            <h4><a href="#">Sub category</a></h4>
                                            <ul class="items">
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown_subcategory">
                                            <h4><a href="#">Sub category</a></h4>
                                            <ul class="items">
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown_subcategory">
                                            <h4><a href="#">Sub category</a></h4>
                                            <ul class="items">
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                                <li><a href="#">Items</a></li>
                                            </ul>
                                        </li>

                                    </ul>
                                </div>
                            </li> -->
                            <?php
                            $getCategory = getCategory($conn);

                            while ($category_array = mysqli_fetch_assoc($getCategory)) {
                                $cat_id = $category_array['cat_id'];
                                $cat_name = $category_array['cat_name'];
                            ?>

                                <li class=cat_menu_main_category>
                                    <a href="products.php?cat_id=<?php echo $cat_id; ?>" class="main_cat_link"><?php echo $cat_name; ?></a>
                                    <?php
                                    $getSubcategory = getSubcategory($conn, $cat_id);
                                    if (mysqli_num_rows($getSubcategory) > 0) {
                                    ?>
                                        <div class="category_dropdown">
                                            <ul>
                                                <?php


                                                while ($subcat_array = mysqli_fetch_assoc($getSubcategory)) {
                                                    $get_products = getProducts($conn, $cat_id, $subcat_array['id'], '', '6', '', '', '');
                                                ?>

                                                    <li class="dropdown_subcategory">
                                                        <h4><a href="products.php?sub_id=<?php echo $subcat_array['id']; ?>"><?php echo $subcat_array['sub_cat_name']; ?></a></h4>
                                                        <ul class="items">
                                                            <?php
                                                            foreach ($get_products as $products) {


                                                            ?>
                                                                <li><a href="#"><?php echo $products['name']; ?></a></li>
                                                            <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                    </li>
                                                <?php
                                                }

                                                ?>

                                            </ul>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Search popup -->
            <!-- starts here  -->
            <div class="search_area">
                <div class="mycontainer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="search_form">
                                <form action="search.php" method="GET">
                                    <input type="text" name="search" placeholder="Search here...">
                                    <button type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </form>
                                <div class="search_close_btn">
                                    <span class="search_close_btn_icon">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ends here -->
            <div class="body_overlay"></div>
            <div class="partial_overlay"></div>
        </header>
        <!-- start main content -->