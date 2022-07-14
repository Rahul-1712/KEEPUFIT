<?php

require 'header.php';

$search_query = get_safe_value($conn, $_GET['search']);

if ($search_query != '') {
    $get_product = getProducts($conn, '', '', '', '', '', '', $search_query);
} else {
?>
    <script>
        // window.location.href = 'index.php';
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
            <li class="breadcrumb_active">Search Results</li>

        </ul>
    </div>
</div>
<!-- ends here -->


<div class="search_page_area">
    <div class="mycontainer">
        <div class="search_page_searched_text">
            <h2>Search Results of "<span><?php echo $search_query ?></span>"</h2>
            <?php

            if (count($get_product) > 0) {
                echo '<span>'.count($get_product).' results</span>';
            } else {
                echo '<span>No results</span>';
            }
            ?>
        </div>
        <div class="product_container">
            <div class="row">
                <div class="product_list clearfix">
                    <div class="row">
                        <!-- Single Product tile -->
                        <?php

                        if (count($get_product) > 0) {
                            foreach ($get_product as $products) {




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
                        }

                        ?>
                        <!-- Ends here-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

require 'footer.php';

?>