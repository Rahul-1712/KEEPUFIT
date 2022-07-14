<?php
require ('_dbconnect.php');
require (SERVER_ROOT_PATH.'/functions.php');

$email = get_safe_value($conn,$_POST['email']);
$password = get_safe_value($conn,$_POST['password']);


$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn,$sql);
$num_rows = mysqli_num_rows($result);

if ($num_rows == 1) {
    while ($row = mysqli_fetch_assoc($result)){
        if (password_verify($password,$row['password'])){
            $_SESSION['USER_LOGGED'] = true;
            $_SESSION['USER_NAME'] = $row['name'];
            $_SESSION['USER_ID'] = $row['id'];

            if(isset($_SESSION['WISHLIST_ID']) && $_SESSION['WISHLIST_ID'] != ''){
                $obj = new Wishlist();
                $obj -> addProduct($conn, $_SESSION['USER_ID'],$_SESSION['WISHLIST_ID']);
                unset($_SESSION['WISHLIST_ID']);
            }

            echo 'logged';
        }else{
            echo 'wrong';
        }
    }
}else{
    echo 'nouser';
}


?>
