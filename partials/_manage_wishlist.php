<?php

require('_dbconnect.php');
require(SERVER_ROOT_PATH . '/functions.php');


$p_id = get_safe_value($conn, $_POST['p_id']);
$type = get_safe_value($conn, $_POST['type']);

$wishlist = new Wishlist();

if (!isset($_SESSION['USER_LOGGED'])){
    $_SESSION['WISHLIST_ID'] = $p_id;
    echo 'not_login';
} else {
    $user_id = $_SESSION['USER_ID'];

    if ($type == 'add'){
        if ($wishlist -> totalProduct($conn,$user_id,$p_id) == 0){
            $wishlist -> addProduct($conn,$user_id,$p_id);
        }
        echo $wishlist -> totalProduct($conn,$user_id,'');
    }

    if ($type == 'remove'){
        $wishlist -> removeProduct($conn,$user_id,$p_id);
        echo 'remove';
    }
}

