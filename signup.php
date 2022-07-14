<?php

require 'header.php';


if (isset($_SESSION['USER_LOGGED']) && $_SESSION['USER_LOGGED'] == 'true') {
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
                <div class="goto_signup_area ">
                    <h2 class="login_header">Already a member?</h2>
                    <p>Login to your keepufit account and start shopping highest quality supplements and clothes at best price.</p>
                    <a href="login.php" class="login_btn">Go to Login</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="login_area">
                    <h2 class="login_header">Register to Keepufit</h2>
                    <form class="login_form" method="post">
                        <input type="name" name="signup_name" id="signup_name" class="" placeholder="Enter Full Name*" />
                        <p class="error_message signup_name_error" id="signup_name_error"></p>
                        <div class="email_group">
                            <input type="email" name="signup_email" id="signup_email" class="" placeholder="Enter Email*" />
                            <button type="button" class="verfiy_btn" id="email_otp" onclick="email_send_otp()">Send OTP</button>
                            <input type="email" name="signup_email_otp" id="signup_email_otp" class="" pattern="[0-9]+" placeholder="Enter OTP" style="margin-left: 10px;" />
                            <button type="button" class="verfiy_btn" id="email_verify" onclick="email_verify_otp()">Verify</button>
                            <p class="verified_message" id="signup_email_verified"></p>
                        </div>
                        <p class="error_message signup_email_error" id="signup_email_error"></p>
                        <div class="email_group">
                            <input type="text" name="signup_mobile" id="signup_mobile" class="" pattern="[0-9]+" placeholder="Enter Mobile No.*" />
                            <button type="button" class="verfiy_btn" id="mobile_otp" onclick="mobile_send_otp()">Send OTP</button>
                            <input type="text" name="signup_mobile_otp" id="signup_mobile_otp" class="" pattern="[0-9]+" placeholder="Enter OTP" style="margin-left: 10px;" />
                            <button type="button" class="verfiy_btn" id="mobile_verify" onclick="mobile_verify_otp()">Verify</button>
                            <p class="verified_message" id="signup_mobile_verified"></p>
                        </div>
                        <p class="error_message signup_mobile_error" id="signup_mobile_error"></p>

                        <input type="password" name="signup_password" id="signup_password" class="" placeholder="Enter Password*" />
                        <p class="error_message signup_password_error" id="signup_password_error"></p>
                        <button type="submit" class="login_btn" id="signup_btn" onclick="signup()" disabled>Sign Up</button>
                        <input type="hidden" name="email_verfied" id="email_verified">
                        <input type="hidden" name="mobile_verfied" id="mobile_verified">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

require 'footer.php';

?>