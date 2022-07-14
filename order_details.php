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
            <li><a href="<?php echo SITE_ROOT_PATH . 'account.php'; ?>">Your Account</a></li>
            <li><a href="<?php echo SITE_ROOT_PATH . 'orders.php'; ?>">Your Orders</a></li>
            <li class="breadcrumb_active">Order details</li>

        </ul>
    </div>
</div>
<!-- ends here -->

<!-- Order table  -->
<!-- start here -->

<div class="orders_details_area">
    <div class="mycontainer">
        <div class="orders_header">
            <h2>Order Details</h2>
        </div>
        <div class="order_details_address">
            <div class="">
                <h4>Shipping Address</h4>
                <p>uhygtfgvbjhcd dshcbdcu sjhcbsbc b ghscb dsjbsd jbdsbuucdsb dshjsdbd</p>
            </div>
            <div class="">
                <h4>Payment Method</h4>
                <p>Cash on delivery</p>
            </div>
            <div class="">
                <h4>Order Summary</h4>
                <p>Item(s) subtotal: <span class="float-right">1245</span></p>
            </div>
        </div>
        <div class="order_details_products">
            <?php
            $order_id = $_GET['order_id'];
            $order_details_sql = "SELECT * FROM order_details WHERE order_id='$order_id' ";
            $order_details_result = mysqli_query($conn, $order_details_sql);

            while ($order_details = mysqli_fetch_assoc($order_details_result)) {
                $getProducts = getProducts($conn, '', '', $order_details['product_id']);
            ?>
                <div class="single_order_product">
                    <div class="orders_items_img">
                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $getProducts[0]['image'] ?>" alt="<?php echo $getProducts[0]['image'] ?>">
                    </div>
                    <div class="orders_items_details">
                        <h5><?php echo $getProducts[0]['name'] ?></h5>
                        <p>Price : &#8377;<?php echo $getProducts[0]['price'] ?></p>
                        <p>Quantity : &#8377;<?php echo $order_details['qty'] ?></p>
                    </div>
                </div>
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