<?php

require 'header.php';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = $_GET['id'];
    $sql =  "SELECT * FROM contactus WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows == 0) {
        header('location : contact.php');
    }
}

?>

<div class="main col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class="main-head">
        <h2>Contact Details</h2>
    </div>

    <?php

    $sql =  "SELECT * FROM contactus WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result)


    ?>
    <div class="form">
        <h4 class="mb-3">Name : </h4>
        <p class="mb-3"><?php echo $row['name']; ?></p>
    </div>
    <div class="form">
        <h4 class="mb-3">Email : </h4>
        <p class="mb-3"><?php echo $row['email']; ?></p>
    </div>
    <div class="form">
        <h4 class="mb-3">Phone No. : </h4>
        <p class="mb-3"><?php echo $row['phone_no']; ?></p>
    </div>
    <div class="form">
        <h4 class="mb-3">Subject : </h4>
        <p class="mb-3"><?php echo $row['subject']; ?></p>
    </div>
    <div class="form">
        <h4 class="mb-3">Message : </h4>
        <p class="mb-3"><?php echo $row['message']; ?></p>
    </div>




</div>

<?php

require 'footer.php';

?>