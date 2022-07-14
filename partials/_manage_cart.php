<?php

require('_dbconnect.php');
require(SERVER_ROOT_PATH . '/functions.php');


$p_id = get_safe_value($conn, $_POST['p_id']);
$qty = get_safe_value($conn, $_POST['qty']);
$type = get_safe_value($conn, $_POST['type']);

$cart = new Cart();

if ($type == 'add') {
    $cart->addProduct($p_id, $qty);
}

if ($type == 'update') {
    $cart->upadteProduct($p_id, $qty);
}

if ($type == 'remove') {
    $cart->removeProduct($p_id);
}

$totalCount = $cart->totalProduct();

echo $totalCount;
