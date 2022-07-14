<?php

require 'header.php';

if (!isset($_SESSION['CHANGE_PASSWORD']) && $_SESSION['CHANGE_PASSWORD'] != true) {
?>
    <script>
        window.location.href = 'index.php';
    </script>
    <?php
}
$error = '';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = get_safe_value($conn, $_POST['change_password']);
    $cpassword = get_safe_value($conn, $_POST['change_cpassword']);

    if ($password == $cpassword) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $email = $_SESSION['CHANGE_PASSWORD_EMAIL'];
        $update = "UPDATE `users` SET `password`='$password_hash' WHERE `email`='$email'";
        mysqli_query($conn, $update);
        unset($_SESSION['CHANGE_PASSWORD']);
        unset($_SESSION['CHANGE_PASSWORD_EMAIL']);

    ?>
        <script>
            window.location.href = 'login.php';
        </script>
<?php
    } else {
        $error = 'Passwords do not match.';
    }
}


?>

<div class="login_signup_container">
    <div class="mycontainer">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="login_area text-center">
                    <h2 class="login_header">Change your password</h2>
                    <form class="login_form" method="post">
                        <input type="password" name="change_password" id="change_password" class="form-control" placeholder="New Password*" />
                        <input type="password" name="change_cpassword" id="change_cpassword" class="form-control" placeholder="Confirm Password*" />
                        <p class="error_message change_cpassword_error" id="change_cpassword_error"><?php echo $error; ?></p>
                        <button type="submit" class="login_btn">Save Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

require 'footer.php';

?>