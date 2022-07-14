<?php

require 'header.php';

?>


<!-- Bread crumb area -->
<!-- start here -->
<div class="breadcrumb_area">
    <div class="mycontainer">
        <ul class="breadcrumb">
            <li><a href="<?php echo SITE_ROOT_PATH; ?>">Home</a></li>
            <li class="breadcrumb_active">Cart</li>

        </ul>
    </div>
</div>
<!-- ends here -->

<!-- Cart table  -->
<!-- start here -->

<div class="cart_area">
    <div class="mycontainer">
        <div class="cart_header">
            <h2>Items In Your Cart</h2>
        </div>
        <div class="cart_container">
            <?php
            $subtotal = 0;
            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                foreach ($_SESSION['cart'] as $key => $value) {
                    $getproduct = getProducts($conn, '', '', $key, '', '', '');
                    $total = $getproduct[0]['price']*$value['qty'];
                    $subtotal = $subtotal + $total;

            ?>
                    <div class="cart_item">
                        <div class="cart_item_image col-lg-2 col-md-2 col-sm-3 col-xs-4">
                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$getproduct[0]['image']  ?> " alt="<?php echo $getproduct[0]['image']  ?>">
                        </div>
                        <div class="cart_item_details col-lg-6 col-md-6 col-sm-4 col-xs-4">
                            <h4 class="cart_item_name"><?php echo $getproduct[0]['name'] ?></h4>
                            <div class="cart_item_quantity">
                                <div class="cart_item_quantity_controller">
                                    <button type="button" class="cart_quantity_btn cart_decrease_btn" onclick="changeCartQuantity(-1,<?php echo $getproduct[0]['product_id'] ?>,<?php echo $getproduct[0]['qty'] ?>)" id="cart_decrease_btn_<?php echo $getproduct[0]['product_id'] ?>">&minus;</button>
                                    <span class="cart_quantity" id="cart_quantity_<?php echo $getproduct[0]['product_id'] ?>"><?php echo $value['qty'] ?></span>
                                    <button type="button" class="cart_quantity_btn cart_increase_btn" onclick="changeCartQuantity(1,<?php echo $getproduct[0]['product_id'] ?>,<?php echo $getproduct[0]['qty'] ?>)" id="cart_increase_btn_<?php echo $getproduct[0]['product_id'] ?>">&plus;</button>
                                </div>
                            </div>
                        </div>
                        <div class="cart_item_price col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <span>&#8377;<?php echo $total ?></span>
                        </div>
                        <div class="remove_cart_item col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <a href="javascript:void(0)" onclick="manageCart(<?php echo $getproduct[0]['product_id'] ?>,'remove')"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                <?php

                }
            } else {
                ?>
                <h3>No Product in cart</h3>
            <?php
            }
            ?>
        </div>
        <div class="subtotal_container">
            <h3>Subtotal</h3>
            <span class="subtotal_price">&#8377;<?php echo $subtotal ?></span>
        </div>
        <div class="cart_btn_container">
            <a href="<?php echo SITE_ROOT_PATH; ?>" class="continue_shopping_btn">Continue shopping</a>
            <a href="checkout.php" class="checkout_btn">Checkout</a>
        </div>
    </div>
</div>

<!-- ends here  -->

<?php
require 'footer.php';
?>