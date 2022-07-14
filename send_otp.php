<?php

require 'partials/_dbconnect.php';
require 'functions.php';
require 'partials/smtp/PHPMailerAutoload.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $type = get_safe_value($conn, $_POST['type']);
    if ($type == 'email') {
        $email = get_safe_value($conn, $_POST['email']);

        $sql = "SELECT * FROM users where email='$email'";
        $result = mysqli_query($conn, $sql);

        $num_rows = mysqli_num_rows($result);

        if ($num_rows == 0) {
            $otp = rand(111111, 999999);
            // $_SESSION['EMAIL_OTP'] = $otp;
            $_SESSION['EMAIL_OTP'] = 123456;
        } else {
            echo 'exists';
            die();
        }

        $html = '
        <h1 style="text-align: center;">Verify your email</h1>
        <p style="text-align: center; font-size: 20px;">please enter the below given otp(one time password) to verify your email.</p>
        <h3 style="text-align: center;">' . $otp . '</h3>
        ';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        // $mail->SMTPDebug = 2;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '587';
        $mail->SMTPAuth = true;
        $mail->Username = 'rvish1712@gmail.com';
        $mail->Password = '';
        $mail->setFrom('rvish1712@gmail.com','Keepufit');
        $mail->addReplyTo('rvish1712@gmail.com','Keepufit');
        $mail->addAddress($email);
        $mail->Subject = 'Verify Email OTP';
        $mail->isHTML(true);
        $mail->Body = $html;
        $mail->SMTPOptions = array('ssl'=> array(
            'verify_peer'=>false,
            'verify_peer_name'=>false,
            'allow_self_signed'=>false
        ));

        // if ($mail->send()){
        //     echo 'sent';
        // }else{
        //     echo $mail->SMTPError;
        // }

        echo 'sent';
    }

    if ($type == 'mobile') {

        $mobile = get_safe_value($conn, $_POST['mobile']);

        $sql = "SELECT * FROM users where mobile='$mobile'";
        $result = mysqli_query($conn, $sql);

        $num_rows = mysqli_num_rows($result);

        if ($num_rows == 0) {
            $otp = rand(111111, 999999);
            // $_SESSION['MOBILE_OTP'] = $otp;
            $_SESSION['MOBILE_OTP'] = 123456;
        } else {
            echo 'exists';
            die();
        }
        $msg = 'please enter the given otp(one time password) to verify your number. OTP = ' . $otp;

        // $fields = array(
        //     "sender_id" => "TXTIND",
        //     "message" => $msg,
        //     "route" => "v3",
        //     "numbers" => $mobile,
        // );

        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //   CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
        //   CURLOPT_RETURNTRANSFER => true,
        //   CURLOPT_ENCODING => "",
        //   CURLOPT_MAXREDIRS => 10,
        //   CURLOPT_TIMEOUT => 30,
        //   CURLOPT_SSL_VERIFYHOST => 0,
        //   CURLOPT_SSL_VERIFYPEER => 0,
        //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //   CURLOPT_CUSTOMREQUEST => "POST",
        //   CURLOPT_POSTFIELDS => json_encode($fields),
        //   CURLOPT_HTTPHEADER => array(
        //     "authorization: VHZzBdxg3t9jNLC5YeqSuW61IsEa8hUloO2yrvnwpMK40RA7JXNlTzOP70L5aMD1bSIiJ4CufY9evQjt",
        //     "accept: */*",
        //     "cache-control: no-cache",
        //     "content-type: application/json"
        //   ),
        // ));

        // $response = curl_exec($curl);
        // $err = curl_error($curl);

        // curl_close($curl);

        // if ($err) {
        //   echo "cURL Error #:" . $err;
        // } else {
        //   echo 'sent';
        // }

        echo 'sent';
    }

    if ($type == 'forgot') {
        $email = get_safe_value($conn, $_POST['email']);

        $sql = "SELECT * FROM users where email='$email'";
        $result = mysqli_query($conn, $sql);

        $num_rows = mysqli_num_rows($result);

        if ($num_rows > 0) {
            $otp = rand(111111, 999999);
            // $_SESSION['EMAIL_OTP'] = $otp;
            $_SESSION['FORGOT_OTP'] = 123456;
        } else {
            echo 'notexists';
            die();
        }

        $html = '
        <h1 style="text-align: center;">Verify your email</h1>
        <p style="text-align: center; font-size: 20px;">please enter the below given otp(one time password) to verify your email.</p>
        <h3 style="text-align: center;">' . $otp . '</h3>
        ';

        // $mail = new PHPMailer(true);
        // $mail->isSMTP();
        // // $mail->SMTPDebug = 2;
        // $mail->Host = 'smtp.gmail.com';
        // $mail->Port = '587';
        // $mail->SMTPAuth = true;
        // $mail->Username = '';
        // $mail->Password = '';
        // $mail->setFrom('','');
        // $mail->addReplyTo('','');
        // $mail->addAddress('');
        // $mail->Subject = 'Verify Email OTP';
        // $mail->isHTML(true);
        // $mail->Body = $html;
        // $mail->SMTPOptions = array('ssl'=> array(
        //     'verify_peer'=>false,
        //     'verify_peer_name'=>false,
        //     'allow_self_signed'=>false
        // ));

        // if ($mail->send()){
        //     echo 'sent';
        // }else{
        //     echo $mail->SMTPError;
        // }

        echo 'sent';
    } 
}
