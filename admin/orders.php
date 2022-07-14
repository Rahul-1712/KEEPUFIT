<?php

require 'header.php';

$new_selected = '';
$pending_selected = '';
$processing_selected = '';
$shipped_selected = '';
$cancelled_selected = '';
$completed_selected = '';
$cod_selected = '';
$payu_selected = '';
$payment_pending_selected = '';
$payment_completed_selected = '';

if (isset($_GET['sort_by']) && $_GET['sort_by'] != '') {
    $sql =  "SELECT orders.*,order_status.* FROM `orders`,order_status WHERE orders.order_status = order_status.status_id";
    if ($_GET['sort_by'] == 'new') {

        $sql.= " ORDER BY placed_on DESC";
        $new_selected = 'selected';
    }
    elseif ($_GET['sort_by'] == 'pending') {

        $sql.= " and orders.order_status = 1";
        $pending_selected = 'selected';

    }
    elseif ($_GET['sort_by'] == 'processing') {

        $sql.= " and orders.order_status = 2";
        $processing_selected = 'selected';

    }
    elseif ($_GET['sort_by'] == 'shipped') {

        $sql.= " and orders.order_status = 3";
        $shipped_selected = 'selected';

    }
    elseif ($_GET['sort_by'] == 'cancelled') {

        $sql.= " and orders.order_status = 4";
        $cancelled_selected = 'selected';

    }
    elseif ($_GET['sort_by'] == 'completed') {

        $sql.= " and orders.order_status = 5";
        $completed_selected = 'selected';

    }
    elseif ($_GET['sort_by'] == 'cod') {

        $sql.= " and orders.payment_type = 'cod'";
        $cod_selected = 'selected';

    }
    elseif ($_GET['sort_by'] == 'payu') {

        $sql.= " and orders.payment_type = 'payu'";
        $payu_selected = 'selected';

    }
    elseif ($_GET['sort_by'] == 'payment_pending') {

        $sql.= " and orders.payment_status = 'pending'";
        $payment_pending_selected = 'selected';

    }
    elseif ($_GET['sort_by'] == 'payment_completed') {

        $sql.= " and orders.payment_status = 'success'";
        $payment_completed_selected = 'selected';

    }
    else{
        $sql =  "SELECT orders.*,order_status.* FROM `orders`,order_status WHERE orders.order_status = order_status.status_id ORDER BY placed_on DESC";
    }

}else{
    $sql =  "SELECT orders.*,order_status.* FROM `orders`,order_status WHERE orders.order_status = order_status.status_id ORDER BY placed_on DESC";

}

$result = mysqli_query($conn, $sql);

?>

<div class="main">

    <div class="main-head">
        <h2>Orders</h2>
        <select class="sort" name="sort" id="order_sort">
            <option>Sort By</option>
            <option <?php echo $new_selected?> value="1">New Order</option>
            <option <?php echo $pending_selected?> value="2">Order Pending</option>
            <option <?php echo $processing_selected?> value="3">Order Processing</option>
            <option <?php echo $shipped_selected?> value="4">Order Shipped</option>
            <option <?php echo $cancelled_selected?> value="5">Order Cancelled</option>
            <option <?php echo $completed_selected?> value="6">Order Completed</option>
            <option <?php echo $cod_selected?> value="7">Payment type COD</option>
            <option <?php echo $payu_selected?> value="8">Payment type Payu</option>
            <option <?php echo $payment_pending_selected?> value="9">Payment Pending</option>
            <option <?php echo $payment_completed_selected?> value="10">Payment Completed</option>

        </select>
    </div>
    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th class="product-name"><span class="nobr">Order Id</span></th>
                    <th class="product-stock-stauts"><span class="nobr">Address</span></th>
                    <th class="status"><span class="nobr">Payment Type</span></th>
                    <th class="status"><span class="nobr">Payment Status</span></th>
                    <th class="status"><span class="nobr">Order Status</span></th>
                    <th class="actions"><span class="nobr">Action</span></th>
                </tr>
            </thead>
            <tbody>
                <?php



                while ($row = mysqli_fetch_assoc($result)) {

                ?>
                    <tr>
                        <td class="product-remove"><?php echo $row['id'] ?></td>
                        <td class="product-thumbnail"><?php echo $row['address'] . ',' . $row['area']; ?></td>
                        <td class="status"><?php echo $row['payment_type'] ?></td>
                        <td class="status"><?php echo $row['payment_status'] ?></td>
                        <td class="status"><?php echo $row['status_name'] ?></td>
                        <td class="actions"><a class="btn btn-dark" href="order_details.php?order_id=<?php echo $row['id'] ?>">View Details</a></td>
                    </tr>
                <?php
                }

                ?>
            </tbody>




        </table>

    </div>

</div>

<?php

require 'footer.php';

?>