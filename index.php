<?php
require 'header.php';
?>

<!-- Image slider -->
<!-- Starts here -->

<div class="slider_container">
    <div class="slides">
        <img class="slider_img" src="assets/slider images/slider1.png" alt="Slider Image">
    </div>
    <div class="slides">
        <img class="slider_img" src="assets/slider images/slider2.png" alt="Slider Image">
    </div>
    <div class="slides">
        <img class="slider_img" src="assets/slider images/brownie.png" alt="Slider Image">
    </div>
    <div class="slides">
        <img class="slider_img" src="assets/slider images/clothes.jpg" alt="Slider Image">
    </div>

    <button class="slider_btn prev" onclick="plusSlides(-1)"><i class="fa fa-chevron-left"></i></button>
    <button class="slider_btn next" onclick="plusSlides(1)"><i class="fa fa-chevron-right"></i></button>

    <div class="slider_dots">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
    </div>

</div>

<!-- Ends here -->

<!-- Product Categories Section -->
<!-- Starts here -->
<section class="product_category_section">
    <div class="mycontainer">
        <div class="row">
            <div class="col-xs-12 col-12">
                <div class="section_title">
                    <h2>New Arrivals</h2>
                    <p>Matching style and class with luxury and comfort.</p>
                </div>
            </div>
        </div>
        <div class="product_container">
            <div class="row">
                <div class="product_list clearfix">
                    <div class="row">
                        <!-- Single Product tile -->
                        <?php
                        $newArrivals_arr = getProducts($conn, '', '', '', $limit = '4');

                        foreach ($newArrivals_arr as $newArrivals) {
                        ?>


                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="product_tile">
                                    <div class="product_img">
                                        <a href="product_details.php?p_id=<?php echo $newArrivals['product_id'] ?>">
                                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $newArrivals['image'] ?>" alt="<?php echo $newArrivals['image'] ?>">
                                        </a>
                                    </div>
                                    <div class="hover_buttons">
                                        <ul class="product_action">
                                            <li><a href="javascript:void(0)" onclick="manageWishlist(<?php echo $newArrivals['product_id'] ?>,'add')"><i class="fa fa-shopping-bag"></i></a></li>
                                            <li><a href="javascript:void(0)" onclick="manageCart(<?php echo $newArrivals['product_id'] ?>,'add')"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product_details">
                                        <h4><a href="product_details.php?p_id=<?php echo $newArrivals['product_id'] ?>"><?php echo $newArrivals['name'] ?></a></h4>
                                        <div class="product_prize">
                                            <span class="old_prize">&#8377;<?php echo $newArrivals['mrp'] ?></span>
                                            <span>&#8377;<?php echo $newArrivals['price'] ?></span>
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
    </div>
    </div>
</section>
<!-- Ends here -->

<!-- Starts here -->
<section class="product_category_section">
    <div class="mycontainer">
        <div class="row">
            <div class="col-xs-12 col-12">
                <div class="section_title">
                    <h2>Best Sellers</h2>
                    <p>Products Most Loved by our Customers.</p>
                </div>
            </div>
        </div>
        <div class="product_container">
            <div class="row">
                <div class="product_list clearfix">
                    <div class="row">
                        <!-- Single Product tile -->
                        <?php
                        $bestSeller_arr = getProducts($conn, '', '', '', $limit = '4', $is_bestseller = true);

                        foreach ($bestSeller_arr as $bestSeller) {
                        ?>
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="product_tile">
                                    <div class="product_img">
                                        <a href="product_details.php?p_id=<?php echo $bestSeller['product_id'] ?>">
                                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $bestSeller['image'] ?>" alt="<?php echo $bestSeller['image'] ?>">
                                        </a>
                                    </div>
                                    <div class="hover_buttons">
                                        <ul class="product_action">
                                            <li><a href="javascript:void(0)" onclick="manageWishlist(<?php echo $bestSeller['product_id'] ?>,'add')"><i class="fa fa-shopping-bag"></i></a></li>
                                            <li><a href="javascript:void(0)" onclick="manageCart(<?php echo $bestSeller['product_id'] ?>,'add')"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product_details">
                                        <h4><a href="product_details.php?p_id=<?php echo $bestSeller['product_id'] ?>"><?php echo $bestSeller['name'] ?></a></h4>
                                        <div class="product_prize">
                                            <span class="old_prize">&#8377;<?php echo $bestSeller['mrp'] ?></span>
                                            <span>&#8377;<?php echo $bestSeller['price'] ?></span>
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
    </div>
    </div>
</section>
<!-- Ends here -->


<?php
require 'footer.php';
?>