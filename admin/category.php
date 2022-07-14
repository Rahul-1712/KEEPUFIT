<?php

require 'header.php';

if (isset($_GET['action'])) {
    if (isset($_GET['cat_id'])) {
        $cat_id = $_GET['cat_id'];
        if ($_GET['action'] == 'activate') {
            $update = "UPDATE `categories` SET `cat_status`='1' WHERE cat_id='$cat_id'";
            mysqli_query($conn, $update);
        }

        if ($_GET['action'] == 'deactivate') {
            $update = "UPDATE `categories` SET `cat_status`='0' WHERE cat_id='$cat_id'";
            mysqli_query($conn, $update);
        }

        if ($_GET['action'] == 'delete') {
            $sql = "DELETE FROM `categories` WHERE cat_id='$cat_id'";
            mysqli_query($conn, $sql);
        }
    }

    if (isset($_GET['id'])){
        $id = $_GET['id'];
    if ($_GET['action'] == 'activate'){
        $update = "UPDATE `sub_categories` SET `sub_cat_status`='1' WHERE id='$id'";
        mysqli_query($conn, $update);
    }

    if ($_GET['action'] == 'deactivate'){
        $update = "UPDATE `sub_categories` SET `sub_cat_status`='0' WHERE id='$id'";
        mysqli_query($conn, $update);
    }

    if ($_GET['action'] == 'delete'){
        $sql = "DELETE FROM `sub_categories` WHERE id='$id'";
        mysqli_query($conn, $sql);
    }
    }
}

?>

<div class="main">

    <div class="main-head">
        <h2>Categories</h2>
        <a class="btn btn-dark btn-position" href="manage_category.php">Add Category</a>
    </div>
    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th class="id">Sr.no.</th>
                    <th class="name">Category Name</th>
                    <th class="status">Status</th>
                    <th class="actions">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $sql = "SELECT * FROM categories";
                $result = mysqli_query($conn, $sql);

                $srno = 0;
                while ($row = mysqli_fetch_array($result)) {
                    $srno += 1;
                ?>
                    <tr>
                        <td><?php echo $srno ?></td>
                        <td><?php echo $row['cat_name'] ?></td>
                        <td class="status">
                            <?php
                            if ($row['cat_status'] == 0) {
                                echo '<a class="btn btn-success" href="category.php?action=activate&cat_id=' . $row['cat_id'] . '">Activate</a>';
                            } else {
                                echo '<a class="btn btn-success" href="category.php?action=deactivate&cat_id=' . $row['cat_id'] . '">Deactivate</a>';
                            }
                            ?>

                        </td>
                        <td class="actions">
                            <a class="btn btn-primary" href="manage_category.php?cat_id=<?php echo $row['cat_id'] ?>">Edit</a>
                            <a class="btn btn-danger" href="category.php?action=delete&cat_id=<?php echo $row['cat_id'] ?>">Delete</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

    </div>

    <!-- Sub Category Section -->

    <div class="main-head">
        <h2>Sub Categories</h2>
        <a class="btn btn-dark btn-position" href="manage_subcategory.php">Add Category</a>
    </div>
    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th class="id">Sr.no.</th>
                    <th class="name">Subcategory Name</th>
                    <th class="name">Category Name</th>
                    <th class="status">Status</th>
                    <th class="actions">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $sql = "SELECT * FROM sub_categories,categories WHERE sub_categories.cat_id=categories.cat_id";
                $result = mysqli_query($conn, $sql);

                $srno = 0;
                while ($row = mysqli_fetch_array($result)) {
                    $srno += 1;
                ?>
                    <tr>
                        <td><?php echo $srno ?></td>
                        <td><?php echo $row['sub_cat_name'] ?></td>
                        <td><?php echo $row['cat_name'] ?></td>
                        <td class="status">
                            <?php
                            if ($row['sub_cat_status'] == 0) {
                                echo '<a class="btn btn-success" href="category.php?action=activate&id=' . $row['id'] . '">Activate</a>';
                            } else {
                                echo '<a class="btn btn-success" href="category.php?action=deactivate&id=' . $row['id'] . '">Deactivate</a>';
                            }
                            ?>

                        </td>
                        <td class="actions">
                            <a class="btn btn-primary" href="manage_subcategory.php?id=<?php echo $row['id'] ?>">Edit</a>
                            <a class="btn btn-danger" href="category.php?action=delete&id=<?php echo $row['id'] ?>">Delete</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

    </div>

</div>

<?php

require 'footer.php';

?>