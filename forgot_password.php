<?php

require 'header.php';

?>

<div class="login_signup_container">
    <div class="mycontainer">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="login_area text-center">
                    <h2 class="login_header">Enter your registerd email</h2>
                    <form class="login_form" method="post">
                        <div class="email_group">
                            <input type="email" name="forgot_email" id="forgot_email" class="" placeholder="Enter Email*" />
                            <input type="email" name="forgot_email_otp" id="forgot_email_otp" class="" pattern="[0-9]+" placeholder="Enter OTP" style="margin-left: 10px;" />
                        </div>
                        <p class="error_message forgot_email_error" id="forgot_email_error"></p>
                        <button type="button" class="verfiy_btn" id="forgot_otp" onclick="forgot_send_otp()">Send OTP</button>
                        <button type="button" class="verfiy_btn" id="forgot_verify" onclick="forgot_verify_otp()">Verify</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

require 'footer.php';

?>