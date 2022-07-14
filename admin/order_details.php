<?php

require 'header.php';

if (isset($_SERVER['REQUEST_METHOD']) != '' && $_SERVER['REQUEST_METHOD']==='POST') {
    $update_order_status = $_POST['order_status'];
    $update_order_id = $_GET['order_id'];

    $sql = "UPDATE `orders` SET `order_status`='$update_order_status' WHERE id='$update_order_id'";
    $result= mysqli_query($conn, $sql);
}

?>

<div class="main col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class="main-head">
        <h2>Orders Details</h2>
    </div>
    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th class="product-thumbnail">Product Image</th>
                    <th class="product-name"><span class="nobr">Product Name</span></th>
                    <th class="product-price"><span class="nobr"> Unit Price </span></th>
                    <th class="product-stock-stauts"><span class="nobr">Qty</span></th>
                    <th class="product-add-to-cart"><span class="nobr">Total</span></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $order_id = $_GET['order_id'];
                $sql =  "SELECT products.*, order_details.* FROM `products`,`order_details` WHERE order_details.order_id='$order_id' and products.product_id=order_details.product_id";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {


                ?>
                    <tr>
                        <td class="product-thumbnail"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $row['image']; ?>" alt="<?php echo $row['image']; ?>" style="width:130px;" /></td>
                        <td class="product-name"><?php echo $row['name']; ?></td>
                        <td class="product-price"><span class="amount">&#8377;<?php echo $row['price']; ?></span></td>
                        <td class="product-stock-status"><?php echo $row['qty']; ?></td>
                        <td class="product-add-to-cart"><?php echo $row['price'] * $row['qty']; ?></td>
                    </tr>
                <?php
                }

                ?>
            </tbody>

        </table>
        

    </div>
    <?php

        $sql =  "SELECT * FROM orders WHERE id='$order_id'";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $address = $row['address'];
            $area = $row['area'];
            $city = $row['city'];
            $state = $row['state'];
            $pincode = $row['pincode'];
            $order_status = $row['order_status'];
        }
        ?>
        <div class="form">
            <h4 class="mb-3">Address to be delivered at :</h4>
            <p><?php echo $address . ', ' . $area . ', ' . $city . ', ' . $state . ', ' . $pincode; ?></p>
        </div>

        <div class="form">
            <h4 class="mb-3">Update Order Status</h4>
            <form action="order_details.php?order_id=<?php echo $order_id; ?>" method="post">

                <div class="form-floating mb-3">
                    <select class="form-select" name="order_status" id="floatingSelect" aria-label="Floating label select example">

                        <?php
                        $sql = "SELECT * FROM order_status";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['status_id'] == $order_status) {
                                echo '<option selected value="' . $row['status_id'] . '">' . $row['status_name'] . '</option>';
                            } else {
                                echo '<option value="' . $row['status_id'] . '">' . $row['status_name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <label for="floatingSelect">Select Status</label>
                </div>
                <button type="submit" class="btn btn-dark">Update Status</button>
            </form>
        </div>

</div>

<?php

require 'footer.php';

?>