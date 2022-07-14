<?php

require 'header.php';
$id='';
$cat_id = '';
$sub_cat_name = '';
$sub_cat_status = '';
$is_error = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM categories,sub_categories WHERE sub_categories.id='$id'";

    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows > 0) {
        $row = mysqli_fetch_assoc($result);

        $cat_id = $row['cat_id'];
        $sub_cat_name = $row['sub_cat_name'];
        $cat_name = $row['cat_name'];
        $sub_cat_status = $row['sub_cat_status'];
    } else {
        header('location: category.php');
    }
}

if (isset($_SERVER['REQUEST_METHOD'])  && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $sub_cat_name = $_POST['sub_cat_name'];
    $cat_id= $_POST['cat_id'];
    $sub_cat_status = $_POST['sub_cat_status'];

    $sql = "SELECT * FROM sub_categories WHERE sub_cat_name='$sub_cat_name'";

    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows == 0) {
        
        if (isset($_GET['id'])){
            $id = $_GET['id'];
            $update = "UPDATE `sub_categories` SET `cat_id`='$cat_id',`sub_cat_name`='$sub_cat_name',`sub_cat_status`='$sub_cat_status' WHERE id='$id'";
            mysqli_query($conn, $update);
            header('location: category.php');
        }else{
            $insert = "INSERT INTO `sub_categories`(`cat_id`, `sub_cat_name`, `sub_cat_status`) 
                        VALUES ('$cat_id','$sub_cat_name','$sub_cat_status')";
            mysqli_query($conn, $insert);
            header('location: category.php');
        }
        
    }else{
        $is_error = 'Sub category already exists.';
    }
}



?>

<div class="main">

    <div class="main-head">
        <h2>Manage Sub category</h2>
    </div>
    <div class="form">
        <form method="post">

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="sub_cat_name" id="sub_cat_name" placeholder="name@example.com" value="<?php echo $sub_cat_name ?>" required>
                <label for="sub_cat_name">Enter Subcategory Name</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" name="cat_id" id="floatingSelect" aria-label="Floating label select example">

                    <?php
                        $sql= "SELECT * FROM categories";
                        $result = mysqli_query($conn,$sql);
                        while($row = mysqli_fetch_assoc($result)){
                            if ($row['cat_id'] == $cat_id) {
                                echo '<option selected value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                            } else {
                                echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                            }
                        }
                    ?>


                </select>
                <label for="floatingSelect">Set Status</label>
            </div>
            <div class="form-floating">
                <select class="form-select" name="sub_cat_status" id="floatingSelect" aria-label="Floating label select example">

                    <?php
                    if ($sub_cat_status == 0) {
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

            <button class="btn btn-primary " id="submit_sub_category" type="submit">Submit</button>
        </form>
    </div>
</div>

<?php

require 'footer.php';

?>