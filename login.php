<?php

require 'header.php';


if ($logged) {
?>
    <script>
        window.location.href = 'index.php';
    </script>
<?php
}

?>

<div class="login_signup_container">
    <div class="mycontainer">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="login_area">
                    <h2 class="login_header">Login</h2>
                    <form class="login_form" method="post">
                        <input type="email" name="login_email" id="login_email" class="form-control" placeholder="Email*" />
                        <p class="error_message login_email_error" id="login_email_error"></p>
                        <input type="password" name="login_password" id="login_password" class="form-control" placeholder="Password*" />
                        <p class="error_message login_password_error" id="login_password_error"></p>
                        <button type="button" onclick="login()" class="login_btn">Login</button>
                        <a href="forgot_password.php">Forgot Password?</a>
                    </form>

                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="goto_signup_area ">
                    <h2 class="login_header">New to Keepufit?</h2>
                    <p>Sign Up for a keepufit account to gain access to highest quality supplements and clothes at best price.</p>
                    <a href="signup.php" class="login_btn">Go to sign up</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

require 'footer.php';

?>