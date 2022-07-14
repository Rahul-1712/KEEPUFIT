<?php

require 'header.php';

$cat_id = '';
$cat_name = '';
$cat_status = '';
$is_error = '';

if (isset($_GET['cat_id'])) {
    $cat_id = $_GET['cat_id'];

    $sql = "SELECT * FROM categories WHERE cat_id='$cat_id'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows > 0) {
        $row = mysqli_fetch_assoc($result);

        $cat_name = $row['cat_name'];
        $cat_status = $row['cat_status'];
    } else {
        header('location: category.php');
    }
}

if (isset($_SERVER['REQUEST_METHOD'])  && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $cat_name = $_POST['cat_name'];
    $cat_id= $_POST['cat_id'];
    $cat_status = $_POST['cat_status'];

    $sql = "SELECT * FROM categories WHERE cat_name='$cat_name'";

    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows == 0) {
        if (isset($_GET['cat_id'])){
            $cat_id = $_GET['cat_id'];
            $update = "UPDATE `categories` SET `cat_name`='$cat_name',`cat_status`='$cat_status' WHERE cat_id='$cat_id'";
            mysqli_query($conn, $update);
            header('location: category.php');

        }else{
            $insert = "INSERT INTO `categories`(`cat_name`, `cat_status`) 
                        VALUES ('$cat_name','$cat_status')";
            mysqli_query($conn, $insert);
            header('location: category.php');
        }
        
    }else{
        $is_error = 'Category already exists.';
    }
}



?>

<div class="main">

    <div class="main-head">
        <h2>Manage Category</h2>
    </div>
    <div class="form">
        <form method="post">

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="cat_name" id="cat_name" placeholder="name@example.com" value="<?php echo $cat_name ?>" required>
                <label for="cat_name">Enter Category Name</label>
            </div>
            <div class="form-floating">
                <select class="form-select" name="cat_status" id="floatingSelect" aria-label="Floating label select example">

                    <?php
                    if ($cat_status == 0) {
                        echo '<option selected value="1">Activated</option>
                        <option value="0">Deactivated</option>';
                    } else {
                        echo '<option selected value="1">Activated</option>
                        <option value="0">Deactivated</option>';
                    }
                    ?>


                </select>
                <label for="floatingSelect">Set Status</label>
            </div>

            <p class="error mt-3"><?php echo $is_error ?></p>

            <button class="btn btn-primary " id="submit_category" type="submit">Submit</button>
        </form>
    </div>
</div>

<?php

require 'footer.php';

?>