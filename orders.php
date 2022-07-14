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
            <li class="breadcrumb_active">Your Orders</li>

        </ul>
    </div>
</div>
<!-- ends here -->

<!-- Order table  -->
<!-- start here -->

<div class="orders_area">
    <div class="mycontainer">
        <div class="orders_header">
            <h2>Your orders</h2>
        </div>
        <div class="current_orders">
            <?php
            $user_id = $_SESSION['USER_ID'];
            $sql = "SELECT * FROM orders,order_status WHERE orders.user_id='$user_id' and `orders`.order_status=`order_status`.status_id ORDER BY id DESC";
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);
            
            if ($num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

            ?>
                    <div class="orders_orders">
                        <div class="orders_order_detail">
                            <div>
                                <p>ORDER PLACED</p>
                                <p><?php echo substr($row['placed_on'], 0, 10) ?></p>
                            </div>
                            <div>
                                <p>TOTAL COST</p>
                                <p><?php echo $row['total_cost'] ?></p>
                            </div>
                            <div>
                                <p>Order Status</p>
                                <p><?php echo $row['status_name'] ?></p>
                            </div>
                            <div>
                                <p>Order Id: <?php echo $row['id'] ?></p>
                                <p><a href="order_details.php?order_id=<?php echo $row['id'] ?>">View details</a></p>
                            </div>
                        </div>
                        <div class="orders_details_items">
                            <?php
                            $order_id = $row['id'];
                            $order_details_sql = "SELECT * FROM order_details WHERE order_id='$order_id' ";
                            $order_details_result = mysqli_query($conn, $order_details_sql);
                            
                                while ($order_details = mysqli_fetch_assoc($order_details_result)) {
                                    $getProducts = getProducts($conn,'','',$order_details['product_id']);
                            ?>
                                    <div class="orders_items">
                                        <div class="orders_items_img">
                                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $getProducts[0]['image'] ?>" alt="<?php echo $getProducts[0]['image'] ?>">
                                        </div>
                                        <div class="orders_items_details">
                                            <h5><?php echo $getProducts[0]['name'] ?></h5>
                                        </div>
                                    </div>
                            <?php
                                }
                            
                            ?>
                        </div>
                    </div>
            <?php
                }
            }else{
                ?>
                <h3>No Orders Placed.</h3>
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