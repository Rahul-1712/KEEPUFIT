<?php
require 'partials/_dbconnect.php';
require('functions.php');
// echo'<pre>';
// print_r($_POST);
$mihpayid = $_POST['mihpayid'];
$status=$_POST["status"];
// $status = 'failed';

$firstname = $_POST["firstname"];
$amount = $_POST["amount"];
$txnid = $_POST["txnid"];
$posted_hash = $_POST["hash"];
$key = $_POST["key"];
$productinfo = $_POST["productinfo"];
$email = $_POST["email"];
$salt = "TuxqAugd";

// Salt should be same Post Request 

if (isset($_POST["additionalCharges"])) {
      $additionalCharges = $_POST["additionalCharges"];
      $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
} else {
      $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
}
$hash = hash("sha512", $retHashSeq);
if ($hash != $posted_hash) {
      $upadte ="UPDATE `orders` SET `payment_status`='$status',`mihpayid`='$mihpayid' WHERE txnid='$txnid'";
      mysqli_query($conn,$upadte);
?>
      <script>
            window.location.href = 'checkout.php?status=<?php echo $status; ?>&txnid=<?php echo $txnid; ?>';
      </script>
<?php
} else {

      $upadte = "UPDATE `orders` SET `payment_status`='$status',`mihpayid`='$mihpayid' WHERE txnid='$txnid'";
      mysqli_query($conn, $upadte);
      if (!isset($_SESSION['USER_LOGGED']) || $_SESSION['USER_LOGGED'] != 'true') {
            $sql = "SELECT * FROM orders WHERE txnid='$txnid'";
            $result = mysqli_query($conn,$sql);
            $row= mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];
            $get_user_sql = "SELECT * FROM users WHERE `id`='$user_id'";
            $user_result = mysqli_query($conn,$get_user_sql);
            $user_row = mysqli_fetch_assoc($user_result);
            $_SESSION['USER_LOGGED'] = true;
            $_SESSION['USER_NAME'] = $user_row['name'];
            $_SESSION['USER_ID'] = $user_row['id'];

            

        }
?>
      <script>
            window.location.href = 'orders.php';
      </script>
<?php
}
?>