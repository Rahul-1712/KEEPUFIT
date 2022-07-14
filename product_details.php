<?php
require 'header.php';

$page_results = '';

if (isset($_GET['p_id'])) {

    $p_id  = get_safe_value($conn, $_GET['p_id']);
    $getproduct = getProducts($conn, '', '', $p_id, '', '', '');
    $page_results = count($getproduct);
}



?>


<?php

if ($page_results > 0) {
?>
    <!-- Bread crumb area -->
    <!-- start here -->
    <div class="breadcrumb_area">
        <div class="mycontainer">
            <ul class="breadcrumb">
                <li><a href="<?php echo SITE_ROOT_PATH; ?>">Home</a></li>
                <li><a href="products.php?cat_id=<?php echo $getproduct[0]['cat_id'] ?>"><?php echo $getproduct[0]['cat_name'] ?></a></li>
                <li><a href="products.php?sub_id=<?php echo $getproduct[0]['sub_cat_id'] ?>"><?php echo $getproduct[0]['sub_cat_name'] ?></a></li>
                <li class="breadcrumb_active"><?php echo $getproduct[0]['name'] ?></li>

            </ul>
        </div>
    </div>
    <!-- ends here -->



    <!-- Product display area -->
    <!-- starts here -->

    <div class="product_display_area">
        <div class="mycontainer">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="product_image_box">
                        <img class="product_image_box_img" src="<?php echo PRODUCT_IMAGE_SITE_PATH . $getproduct[0]['image'] ?>" alt="<?php echo $getproduct[0]['image'] ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="product_info">
                        <h1 class="product_info_name"><?php echo $getproduct[0]['name'] ?></h1>
                        <span class="product_info_mrp">&#8377;<?php echo $getproduct[0]['mrp'] ?></span>
                        <span class="product_info_price">
                            &#8377;<?php echo $getproduct[0]['price'] ?>
                            <span class="product_info_discount">
                                <?php
                                $price = $getproduct[0]['price'];
                                $mrp = $getproduct[0]['mrp'];
                                $discount = ceil(100 - (($price / $mrp) * 100));
                                echo 'Extra ' . $discount . '% off';
                                ?>
                            </span>
                        </span>

                        <div class="product_info_quantity">
                            <p class="product_info_quantity_label">Quantity:</p>
                            <div class="product_info_quantity_controller">
                                <button type="button" class="quantity_btn decrease_btn disabled" id="decrease_btn" disabled>&minus;</button>
                                <label>
                                    <input class="quantity_input" type="number" name="quantity" id="quantity_input" pattern="[0-9]+" value="1" min="1" max="<?php echo $getproduct[0]['qty'] ?>">
                                </label>
                                <button type="button" class="quantity_btn increase_btn" id="increase_btn">&plus;</button>
                            </div>
                        </div>
                        <div class="product_info_btn">
                            <a href="javascript:void(0)" onclick="manageCart(<?php echo $getproduct[0]['product_id'] ?>,'add')" class="product_info_add_to_cart_btn">Add to Cart</a>
                            <a href="javascript:void(0)" onclick="manageWishlist(<?php echo $getproduct[0]['product_id'] ?>,'add')" class="product_info_add_to_wishlist_btn">Save to Wishlist</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product_description_container">
                <div class="product_features_area">
                <h4 class="product_description_header">Features</h4>
                <p class="product_description">
                    <?php echo $getproduct[0]['short_desc']; ?>
                </p>
                </div>
                <div class="product_description_area">
                <h4 class="product_description_header">Description</h4>
                <p class="product_description">
                    <?php echo $getproduct[0]['long_desc']; ?>
                </p>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Ends here -->


<?php
} else {
?>

    <script>
        window.location.href = '<?php echo SITE_ROOT_PATH; ?>';
    </script>

<?php
}
?>

<?php
require 'footer.php';
?>