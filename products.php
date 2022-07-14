<?php
require 'header.php';;

$sub_cat = false;
$cat_id = '';
$sub_cat_id = '';
$page_title = '';
$page_results = '';
$sort_by = '';
$sort_sql = '';
$sort_id = '';

$default_select = '';
$new_select = '';
$old_select = '';
$low_select = '';
$high_select = '';


if (isset($_GET['sortOrder'])) {
    $sort_by = get_safe_value($conn, $_GET['sortOrder']);
    if ($sort_by == 'newest') {

        $sort_sql = " ORDER BY products.product_id DESC";
        $new_select = 'selected';

    }else if ($sort_by == 'oldest') {

        $sort_sql = " ORDER BY products.product_id ASC";
        $old_select = 'selected';

    }else if ($sort_by == 'priceAscending') {

        $sort_sql = " ORDER BY products.price ASC";
        $low_select = 'selected';

    }else if ($sort_by == 'priceDescending') {

        $sort_sql = " ORDER BY products.price DESC";
        $high_select = 'selected';

    }else{
        $sort_sql = " ORDER BY products.product_id DESC";
        $default_select = 'selected';
    }
}

if (isset($_GET['sub_id'])) {
    
    $sub_cat = true;
    $sub_cat_id = get_safe_value($conn, $_GET['sub_id']);
    $getproduct = getProducts($conn, '', $sub_cat_id, '', '', '', $sort_sql);
    $page_title = $getproduct[0]['sub_cat_name'];
    $page_results = count($getproduct);
    $sort_id = $sub_cat_id;
    $sort_cat = 'sub';
    
} else if (isset($_GET['cat_id'])) {

    $cat_id = get_safe_value($conn, $_GET['cat_id']);
    $getproduct = getProducts($conn, $cat_id, '', '', '', '', $sort_sql);
    $page_title = $getproduct[0]['cat_name'];
    $page_results = count($getproduct);
    $sort_id = $cat_id;
    $sort_cat = 'cat';

} else {
?>

    <script>
        window.location.href = '<?php echo SITE_ROOT_PATH; ?>';
    </script>

<?php
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
                <?php
                if ($sub_cat == true) {
                    echo '<li><a href="products.php?cat_id=' . $getproduct[0]['cat_id'] . '">' . $getproduct[0]['cat_name'] . '</a></li>
                <li class="breadcrumb_active">' . $getproduct[0]['sub_cat_name'] . '</li>';
                } else {
                    echo '<li class="breadcrumb_active">' . $getproduct[0]['cat_name'] . '</li>';
                }
                ?>

            </ul>
        </div>
    </div>
    <!-- ends here -->


    <!-- Product area -->
    <div class="product_grid_area">
        <div class="mycontainer">
            <!-- Starts here -->
            <div class="row">
                <div class="col-xs-12 col-12">
                    <div class="row justify-content-between align-items-center">
                        <div class="page_title">
                            <h2><?php echo $page_title ?></h2>
                            <p><?php echo $page_results . ' results'; ?></p>
                        </div>
                        <div class="page_sorting">
                            <select class="sort_dropdown" name="sortOrder" id="sortOrder" onchange="sortOrder(<?php echo $sort_id; ?>,'<?php echo $sort_cat; ?>')">
                                <option <?php echo $default_select; ?> value="default">Deafault Order</option>
                                <option <?php echo $new_select; ?> value="newest">Newest</option>
                                <option <?php echo $old_select; ?> value="oldest">Oldest</option>
                                <option <?php echo $low_select; ?> value="priceAscending">Price Low to High</option>
                                <option <?php echo $high_select; ?> value="priceDescending">Price High to Low</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <div class="product_container">
                <div class="row">
                    <div class="product_list clearfix">
                        <div class="row">
                            <!-- Single Product tile -->
                            <?php

                            foreach ($getproduct as $products) {
                            ?>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                    <div class="product_tile">
                                        <div class="product_img">
                                            <a href="product_details.php?p_id=<?php echo $products['product_id'] ?>">
                                                <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $products['image'] ?>" alt="<?php echo $products['image'] ?>">
                                            </a>
                                        </div>
                                        <div class="hover_buttons">
                                            <ul class="product_action">
                                                <li><a href="javascript:void(0)" onclick="manageWishlist(<?php echo $products['product_id'] ?>,'add')"><i class="fa fa-shopping-bag"></i></a></li>
                                                <li><a href="javascript:void(0)" onclick="manageCart(<?php echo $products['product_id'] ?>,'add')"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product_details">
                                            <h4><a href="product_details.php?p_id=<?php echo $products['product_id'] ?>"><?php echo $products['name'] ?></a></h4>
                                            <div class="product_prize">
                                                <span class="old_prize">&#8377;<?php echo $products['mrp'] ?></span>
                                                <span>&#8377;<?php echo $products['price'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <!-- Ends here-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ends here -->
        </div>
    </div>

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