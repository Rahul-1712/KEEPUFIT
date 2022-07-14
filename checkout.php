<?php
require 'header.php';

if (!$logged) {

?>
    <script>
        window.location.href = 'login.php';
    </script>
<?php
}

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
?>
    <script>
        window.location.href = 'index.php';
    </script>
<?php
}



if (isset($_POST['submit'])) {
    $subtotal = 0;
    foreach ($_SESSION['cart'] as $key => $value) {
        $getproduct = getProducts($conn, '', '', $key, '', '', '');
        $price = $getproduct[0]['price'];
        $qty = $value['qty'];
        $total = $price * $qty;
        $subtotal = $subtotal + $total;
    }

    $user_id = $_SESSION['USER_ID'];
    $address = get_safe_value($conn, $_POST['address']);
    $area = get_safe_value($conn, $_POST['area']);
    $city = get_safe_value($conn, $_POST['city']);
    $state = get_safe_value($conn, $_POST['state']);
    $pincode = get_safe_value($conn, $_POST['pincode']);
    $payment_type = get_safe_value($conn, $_POST['payment_type']);
    $payment_status = '';
    $total_cost = $subtotal;




    if ($payment_type == 'cod') {
        $payment_status = 'pending';
    }
    $order_status = 1;

    // Generating transaction ID 
    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

    $order_query = "INSERT INTO `orders`(`user_id`, `address`, `area`, `city`, `state`, 
    `pincode`, `payment_type`, `total_cost`, `payment_status`, `order_status`, `txnid`)
    VALUES ('$user_id','$address','$area','$city','$state','$pincode',
    '$payment_type','$total_cost','$payment_status','$order_status','$txnid')";

    mysqli_query($conn, $order_query);
    // Returns the order Id of last enterd query.
    $order_id = mysqli_insert_id($conn);


    foreach ($_SESSION['cart'] as $key => $value) {
        $product_array = getProducts($conn, '', '', $key, '', '', '');
        $price = $product_array[0]['price'];
        $qty = $value['qty'];
        $total = $price * $qty;
        $subtotal = $subtotal + $total;

        $insert_order_details = "INSERT INTO `order_details`(`order_id`, `product_id`, `price`, `qty`) 
                                    VALUES ('$order_id','$key','$price','$qty')";

        mysqli_query($conn, $insert_order_details);
    }
    

    if ($payment_type == 'payu'){

        $user_array = array();
        $sql  = "SELECT * FROM `users` WHERE `id` = '$user_id' ";
        $result = mysqli_query($conn, $sql);

        $user_array = mysqli_fetch_assoc($result);
        // Chanage the Merchant key and salt key with the real keys of client.

        $MERCHANT_KEY = "JPM7Fg";
        $SALT = "TuxqAugd";
        // Merchant Key and Salt as provided by Payu.

        $PAYU_BASE_URL = "https://test.payu.in";         // For Sandbox Mode
        //$PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode

        $action = '';

        $formError = 0;


        $posted['key'] = $MERCHANT_KEY;
        $posted['txnid'] = $txnid;
        $posted['amount'] = $total_cost;
        $posted['firstname'] = $user_array['name'];
        $posted['email'] = $user_array['email'];
        $posted['mobile'] = $user_array['mobile'];
        $posted['productinfo'] = "Product_info";
        $hash = '';

        // Hash Sequence
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        if (empty($posted['hash']) && sizeof($posted) > 0) {
            if (
                empty($posted['key'])
                || empty($posted['txnid'])
                || empty($posted['amount'])
                || empty($posted['firstname'])
                || empty($posted['email'])
                || empty($posted['mobile'])
                || empty($posted['productinfo'])

            ) {
                $formError = 1;
            } else {
                $hashVarsSeq = explode('|', $hashSequence);
                $hash_string = '';
                foreach ($hashVarsSeq as $hash_var) {
                    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                    $hash_string .= '|';
                }
                $hash_string .= $SALT;

                $hash = strtolower(hash('sha512', $hash_string));
                $action = $PAYU_BASE_URL . '/_payment';
            }
        } elseif (!empty($posted['hash'])) {
            $hash = $posted['hash'];
            $action = $PAYU_BASE_URL . '/_payment';
        }

        $form_html = '<form action="' . $action . '" method="post" name="payuForm" id="payuForm">
        <input type="hidden" name="key" value="' . $MERCHANT_KEY . '" />
        <input type="hidden" name="hash" value="' . $hash . '"/>
        <input type="hidden" name="txnid" value="' . $txnid . '" />
        <input type="hidden" name="amount" value="' . $posted['amount'] . '" />
        <input type="hidden" name="firstname" id="firstname" value="' . $posted['firstname'] . '" />
        <input type="hidden" name="email" id="email" value="' . $posted['email'] . '" />
        <input type="hidden" name="mobile" value="' . $posted['mobile'] . '" />
        <textarea type="hidden" name="productinfo">' . $posted['productinfo'] . '</textarea>
        <input type="hidden" name="surl" value="' . SITE_ROOT_PATH . '/success.php' . '" size="64" />
        <input type="hidden" name="furl" value="' . SITE_ROOT_PATH . '/success.php' . '" size="64" />
        <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
        
        </form>';

        echo $form_html;
        echo '<script>
        console.log("submit");
        document.getElementById("payuForm").submit();
        </script>';
    } else {

        unset($_SESSION['cart']);

    ?>
        <script>
            window.location.href = 'orders.php';
        </script>
<?php

    
    }
}


?>


<!-- Bread crumb area -->
<!-- start here -->
<div class="breadcrumb_area">
    <div class="mycontainer">
        <ul class="breadcrumb">
            <li><a href="<?php echo SITE_ROOT_PATH; ?>">Home</a></li>
            <li class="breadcrumb_active">Checkout</li>

        </ul>
    </div>
</div>
<!-- ends here -->

<!-- Cart table  -->
<!-- start here -->

<div class="checkout_area">
    <div class="mycontainer">
        <div class="row">
            <div class="checkout_info col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <form action="" method="post">
                    <div class="checkout_address">
                        <h3>Enter your address</h3>
                        <label for="address">Address*</label>
                        <input type="text" name="address" id="address" placeholder="Address" required />
                        <label for="area">Area*</label>
                        <input type="text" name="area" id="area" placeholder="Area" required />
                        <label for="city">City*</label>
                        <input type="text" name="city" id="city" placeholder="City" required />
                        <label for="state">State*</label>
                        <input type="text" name="state" id="state" placeholder="State" required />
                        <label for="pincode">Pincode*</label>
                        <input type="text" name="pincode" id="pincode" placeholder="Pincode" required />
                    </div>
                    <div class="checkout_method">
                        <h3>Select Payment Method</h3>
                        <div class="radio_group">
                            <input type="radio" name="payment_type" id="payu" value="payu">
                            <label for="payu">
                                <div class="payu">
                                    <img src="assets/logo/payu.svg" alt="payu">
                                </div>
                            </label>
                        </div>
                        <div class="radio_group">
                            <input type="radio" name="payment_type" id="cod" value="cod">
                            <label for="cod">Cash on delivery</label>
                        </div>
                    </div>

                    <div class="checkout_btn_area">
                        <button type="submit" name="submit" class="checkout_btn_btn">Checkout Securely Now</button>
                    </div>

                </form>
            </div>
            <div class="checkout_order_list col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <h4>Order List</h4>
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
                                    <div class="checkout_order_product">
                                        <div class="checkout_order_product_image">
                                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $getproduct[0]['image'] ?>" alt="product image">
                                        </div>
                                        <div class="checkout_order_product_details">
                                            <span class="checkout_order_product_name"><?php echo $getproduct[0]['name'] ?></span>
                                            <span class="checkout_order_quantity">Quantity : <?php echo $value['qty'] ?></span>
                                            <span class="checkout_order_price">&#8377;<?php echo $getproduct[0]['price'] ?></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
                <div class="checkout_subtotal_container">
                    <h3>Subtotal</h3>
                    <span class="subtotal_price">&#8377;<?php echo $subtotal ?></span>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ends here  -->

<?php
require 'footer.php';
?>