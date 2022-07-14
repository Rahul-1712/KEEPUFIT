<?php

require 'header.php';

$is_error = '';
$is_image_error = '';


$category_id = '';
$sub_cat_id = '';
$best_seller = '';
$name = '';
$mrp = '';
$price = '';
$qty = '';
$image = '';
$short_desc = '';
$long_desc = '';
$meta_title = '';
$meta_desc = '';
$meta_keyword = '';

$image_required = 'required';

// Assigning values to variables from databse to show the details when editing.

if (isset($_GET['id'])  && $_GET['id'] != '') {
    $image_required = '';

    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE product_id='$id'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows > 0) {
        $row = mysqli_fetch_assoc($result);

        $category_id = $row['category_id'];
        $sub_cat_id = $row['sub_cat_id'];
        $best_seller = $row['best_seller'];
        $name = $row['name'];
        $mrp = $row['mrp'];
        $price = $row['price'];
        $qty = $row['qty'];
        $image = $row['image'];
        $short_desc = $row['short_desc'];
        $long_desc = $row['long_desc'];
        $meta_title = $row['meta_title'];
        $meta_desc = $row['meta_desc'];
        $meta_keyword = $row['meta_keyword'];
    } else {
        header('location:' . SITE_ADMIN_PATH . 'products.php');
    }
}



if (isset($_SERVER['REQUEST_METHOD'])  && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $category_id = $_POST['category_id'];
    $sub_cat_id = $_POST['sub_cat_id'];
    $name = $_POST['name'];
    $mrp = $_POST['mrp'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];

    $short_desc = $_POST['short_desc'];
    $long_desc = $_POST['long_desc'];
    $meta_title = $_POST['meta_title'];
    $meta_desc = $_POST['meta_desc'];
    $meta_keyword = $_POST['meta_keyword'];
    $best_seller = $_POST['best_seller'];



    $sql = "SELECT * FROM products WHERE `name`='$name'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    // Checking if the product name already exists in the database.

    if ($num_rows > 0) {
        // if the product name exists then check if the method is get or not.

        if (isset($_GET['id']) && $_GET['id'] != '') {
            $row = mysqli_fetch_assoc($result);
            if ($id == $row['product_id']) {
                $update = "UPDATE `products` SET `category_id`='$category_id',`sub_cat_id`='$sub_cat_id',`name`='$name',
                `mrp`='$mrp',`price`='$price',`qty`='$qty',`image`='$image',`short_desc`='$short_desc',
                `long_desc`='$long_desc',`best_seller`='$best_seller',`meta_title`='$meta_title',`meta_desc`='$meta_desc',
                `meta_keyword`='$meta_keyword' WHERE `products`.`product_id` = '$id'";
                mysqli_query($conn, $update);

                header('location:' . SITE_ADMIN_PATH . '/products.php');
            } else {
                $is_error = "Product already exists.";
            }
        } else {
            $is_error = "Product already exists.";
        }
    }

    // Checking the image type that is stored in the $_FILES and comparing the format .

    if ($_FILES['image']['type'] != '') {
        if ($_FILES['image']['type'] == 'image/png' || $_FILES['image']['type'] == 'image/jpg' || $_FILES['image']['type'] == 'image/jpeg') {
            $is_image_error = '';
        } else {
            $is_image_error = 'Please select an image with png, jpg or jpeg format only. Your file type is' . $_FILES['image']['type'];
        }
    }

    if (empty($is_image_error) && empty($is_error)) {
        if (isset($_GET['id']) && $_GET['id'] != '') {

            if ($_FILES['image']['name'] != '') {
                $image = $_FILES['image']['name'];
                $tempname = $_FILES['image']['tmp_name'];
                $folder = PRODUCT_IMAGE_SERVER_PATH . $image;
                move_uploaded_file($tempname, $folder);

                $update = "UPDATE `products` SET `category_id`='$category_id',`sub_cat_id`='$sub_cat_id',`name`='$name',
                `mrp`='$mrp',`price`='$price',`qty`='$qty',`image`='$image',`short_desc`='$short_desc',
                `long_desc`='$long_desc',`best_seller`='$best_seller',`meta_title`='$meta_title',`meta_desc`='$meta_desc',
                `meta_keyword`='$meta_keyword' WHERE `products`.`product_id` = '$id'";
                print_r($update);
            } else {
                $update = "UPDATE `products` SET `category_id`='$category_id',`sub_cat_id`='$sub_cat_id',`name`='$name',
                `mrp`='$mrp',`price`='$price',`qty`='$qty',`short_desc`='$short_desc',
                `long_desc`='$long_desc',`best_seller`='$best_seller',`meta_title`='$meta_title',`meta_desc`='$meta_desc',
                `meta_keyword`='$meta_keyword' WHERE `products`.`product_id` = '$id'";
                print_r($update);
            }
        } else {
            $image = $_FILES['image']['name'];
            $tempname = $_FILES['image']['tmp_name'];
            $folder = PRODUCT_IMAGE_SERVER_PATH . $image;
            move_uploaded_file($tempname, $folder);

            $insert = "INSERT INTO `products` (`product_id`, `category_id`,`sub_cat_id`, `name`, `mrp`, `price`, `qty`,
             `image`, `short_desc`, `long_desc`,`best_seller`, `meta_title`, `meta_desc`, `meta_keyword`, `status`) 
            VALUES (NULL, '$category_id','$sub_cat_id', '$name', '$mrp', '$price', '$qty', 
            '$image', '$short_desc', '$long_desc','$best_seller', '$meta_title', '$meta_desc', '$meta_keyword', '1')";
            mysqli_query($conn, $insert);
        }

        header('location:' . SITE_ADMIN_PATH . 'products.php');
    }
}




?>

<div class="main">

    <div class="main-head">
        <h2>Manage Category</h2>
    </div>
    <div class="form">
        <form method="post" enctype="multipart/form-data">
            <div class="form-floating mb-3">
                <select class="form-select" name="category_id" id="floatingSelect" aria-label="Floating label select example">

                    <?php
                    $sql = "SELECT * FROM categories";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['cat_id'] == $category_id) {
                            echo '<option selected value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                        } else {
                            echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                        }
                    }
                    ?>
                </select>
                <label for="floatingSelect">Select Category</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" name="sub_cat_id" id="floatingSelect" aria-label="Floating label select example">

                    <?php
                    $sql = "SELECT * FROM sub_categories";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['id'] == $sub_cat_id) {
                            echo '<option selected value="' . $row['id'] . '">' . $row['sub_cat_name'] . '</option>';
                        } else {
                            echo '<option value="' . $row['id'] . '">' . $row['sub_cat_name'] . '</option>';
                        }
                    }
                    ?>
                </select>
                <label for="floatingSelect">Select Category</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" name="best_seller" id="floatingSelect" aria-label="Floating label select example">

                    <?php

                    if ($best_seller == 1) {
                        echo '<option selected value="1">Yes</option>';
                        echo '<option value="0">No</option>';
                    } elseif ($best_seller == 0) {
                        echo '<option value="1">Yes</option>';
                        echo '<option selected value="0">No</option>';
                    } else {
                        echo '<option value="1">Yes</option>';
                        echo '<option selected value="0">No</option>';
                    }

                    ?>
                </select>
                <label for="floatingSelect">Set as Best Seller</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="floatingPassword" placeholder="Product Name" value="<?php echo $name; ?>" required>
                <label for="floatingPassword">Product Name</label>
            </div>
            <p class="error mt-3"><?php echo $is_error ?></p>
            <div class="form-floating mb-3">
                <input type="text" name="mrp" class="form-control" id="floatingInput" placeholder="Mrp" value="<?php echo $mrp; ?>" required>
                <label for="floatingInput"> Enter Mrp</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="price" class="form-control" id="floatingPassword" placeholder="Price" value="<?php echo $price; ?>" required>
                <label for="floatingPassword">Enter Price</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="qty" class="form-control" id="floatingInput" placeholder="Qty" value="<?php echo $qty; ?>" required>
                <label for="floatingInput">Quantity</label>
            </div>
            <div>
                <label for="formFileLg" class="form-label">Choose an Image</label>
                <input name="image" class="form-control form-control-lg mb-3" id="formFileLg" type="file" <?php echo $image_required; ?>>
            </div>
            <p class="error mt-3"><?php echo $is_image_error ?></p>
            <div class="form-floating mb-3">
                <textarea name="short_desc" class="form-control" placeholder="Short Description" id="floatingTextarea2" style="height: 100px" required><?php echo $short_desc; ?></textarea>
                <label for="floatingTextarea2">Short Description</label>
            </div>
            <div class="form-floating mb-3">
                <textarea name="long_desc" class="form-control" id="floatingTextarea3" placeholder="Long Description" style="height: 100px" required><?php echo $long_desc; ?></textarea>
                <label for="floatingTextarea3">Long Description</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="meta_title" class="form-control" id="floatingInput" placeholder="Meta Title" value="<?php echo $meta_title; ?>">
                <label for="floatingInput">Meta Title</label>
            </div>
            <div class="form-floating mb-3">
                <textarea name="meta_desc" class="form-control" id="floatingTextarea4" placeholder="Meta Description" style="height: 100px"><?php echo $meta_desc; ?></textarea>
                <label for="floatingTextarea4">Meta Description</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="meta_keyword" class="form-control" id="floatingInput" placeholder="Meta Keywords" value="<?php echo $meta_keyword; ?>">
                <label for="floatingInput">Meta Keywords</label>
            </div>

            <button type="submit" id="submit_product" class="btn btn-primary mb-3">
                Submit
            </button>

        </form>
    </div>
</div>

<?php

require 'footer.php';

?>