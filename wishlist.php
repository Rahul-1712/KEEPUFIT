<?php
require 'header.php';

if (!$logged) {
?>
    <script>
        window.location.href = 'index.php';
    </script>
<?php
}


?>


<!-- Bread crumb area -->
<!-- start here -->
<div class="breadcrumb_area">
    <div class="mycontainer">
        <ul class="breadcrumb">
            <li><a href="<?php echo SITE_ROOT_PATH; ?>">Home</a></li>
            <li class="breadcrumb_active">Wishlist</li>

        </ul>
    </div>
</div>
<!-- ends here -->

<!-- Wishlist table  -->
<!-- start here -->

<div class="cart_area">
    <div class="mycontainer">
        <div class="cart_header">
            <h2>Items In Your Wishlist</h2>
        </div>
        <div class="cart_container">
            <?php
            $user_id = $_SESSION['USER_ID'];

            $sql = "SELECT * FROM wishlist WHERE `user_id`='$user_id'";
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);

            if ($num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $getproduct = getProducts($conn, '', '', $row['product_id'], '', '', '');

            ?>
                    <div class="cart_item">
                        <div class="remove_cart_item col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <a href="javascript:void(0)" onclick="manageWishlist(<?php echo $row['product_id']; ?>,'remove')"><i class="fa fa-trash"></i></a>
                        </div>
                        <div class="cart_item_image col-lg-2 col-md-2 col-sm-3 col-xs-4">
                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $getproduct[0]['image']  ?> " alt="<?php echo $getproduct[0]['image']  ?>">
                        </div>
                        <div class="cart_item_details col-lg-5 col-md-6 col-sm-4 col-xs-4">
                            <h4 class="cart_item_name"><?php echo $getproduct[0]['name'] ?></h4>
                            <span class="wishlist_item_price">&#8377;<?php echo $getproduct[0]['price'] ?></span>
                        </div>
                        <div class="cart_item_price col-lg-3 col-md-2 col-sm-2 col-xs-2">
                            <!-- add to cart from wishlist button -->
                            <a href="javascript:void(0)" onclick="manageCart(<?php echo $getproduct[0]['product_id'] ?>,'add')" class="wishlist_add_to_cart_btn">Add to Cart</a>
                        </div>
                    </div>
                <?php

                }
            } else {
                ?>
                <h3>No Products in your Wishlist.</h3>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<!-- ends here  -->

<?php
require 'footer.php';
?>