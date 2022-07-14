<?php

require 'partials/_dbconnect.php';
require 'functions.php';
require 'partials/smtp/PHPMailerAutoload.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $type = get_safe_value($conn,$_POST['type']);
    if ($type == 'email'){
        $otp = get_safe_value($conn,$_POST['otp']);
        if ($otp == $_SESSION['EMAIL_OTP']){
            unset($_SESSION['EMAIL_OTP']);
            echo 'verified';
        }else{
            echo 'wrong';
        }
    }
    else if ($type == 'mobile'){
        $otp = get_safe_value($conn,$_POST['otp']);
        if ($otp == $_SESSION['MOBILE_OTP']){
            unset($_SESSION['MOBILE_OTP']);
            echo 'verified';
        }else{
            echo 'wrong';
        }
    }

    else if ($type == 'forgot'){
        $otp = get_safe_value($conn,$_POST['otp']);
        $email = get_safe_value($conn,$_POST['email']);

        if ($otp == $_SESSION['FORGOT_OTP']){
            unset($_SESSION['FORGOT_OTP']);
            $_SESSION['CHANGE_PASSWORD']= true;
            $_SESSION['CHANGE_PASSWORD_EMAIL']= $email;
            echo 'verified';
        }else{
            echo 'wrong';
        }
    }

}



?>