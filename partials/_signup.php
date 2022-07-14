<?php
require ('_dbconnect.php');
require (SERVER_ROOT_PATH.'/functions.php');

$name = get_safe_value($conn,$_POST['name']);
$email = get_safe_value($conn,$_POST['email']);
$mobile = get_safe_value($conn,$_POST['mobile']);
$password = get_safe_value($conn,$_POST['password']);

$sql = "SELECT * FROM users where email='$email'";
$result = mysqli_query($conn,$sql);

$num_rows = mysqli_num_rows($result);

if ($num_rows == 0) {
    $password_hash = password_hash($password,PASSWORD_DEFAULT);
    $insert = "INSERT INTO `users`(`name`, `email`, `mobile`, `password`)
                 VALUES ('$name','$email','$mobile','$password_hash')";
    mysqli_query($conn,$insert);
    echo 'insert';
}else{
    echo 'exists';
}
?>