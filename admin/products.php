
<?php

require 'header.php';

if (isset($_GET['action'])){
    
    $id = $_GET['id'];
    if ($_GET['action'] == 'activate'){
        $update = "UPDATE `products` SET `status`='1' WHERE product_id='$id'";
        mysqli_query($conn, $update);
    }

    if ($_GET['action'] == 'deactivate'){
        $update = "UPDATE `products` SET `status`='0' WHERE product_id='$id'";
        mysqli_query($conn, $update);
    }

    if ($_GET['action'] == 'delete'){
        $sql = "DELETE FROM `products` WHERE product_id='$id'";
        mysqli_query($conn, $sql);
    }
}

?>

<div class="main">

    <div class="main-head">
        <h2>Products</h2>
        <a class="btn btn-dark btn-position" href="manage_products.php">Add Product</a>
    </div>
    <div class="table-container table-responsive">

        <table>
            <thead>
                <tr>
                    <th class="id">Sr.no.</th>
                    <th class="name">Name</th>
                    <th class="name">Category</th>
                    <th class="name">Subcategory</th>
                    <th class="name">Image</th>
                    <th class="name">Price</th>
                    <th class="name">Mrp</th>
                    <th class="name">Qty</th>
                    <th class="status">Status</th>
                    <th class="actions">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                
                $sql = "SELECT * FROM products, categories,sub_categories WHERE categories.cat_id= products.category_id and categories.cat_id=sub_categories.cat_id and products.sub_cat_id=sub_categories.id and categories.cat_status='1' ORDER BY products.product_id DESC";
                $result = mysqli_query($conn, $sql);

                $srno = 0;
                while ($row = mysqli_fetch_array($result)) {
                    $srno += 1;
                ?>
                    <tr>
                        <td><?php echo $srno ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['cat_name'] ?></td>
                        <td><?php echo $row['sub_cat_name'] ?></td>
                        <td><img class='product_img' src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image'] ?>" alt="<?php echo $row['image'] ?>"></td>
                        <td><?php echo $row['price'] ?></td>
                        <td><?php echo $row['mrp'] ?></td>
                        <td><?php echo $row['qty'] ?></td>
                        <td class="status">
                            <?php
                                if ($row['status'] == 0){
                                    echo '<a class="btn btn-success" href="products.php?action=activate&product_id='.$row['product_id'].'">Activate</a>';
                                }else{
                                    echo '<a class="btn btn-success" href="products.php?action=deactivate&product_id='.$row['product_id'].'">Deactivate</a>';
                                }
                            ?>
                            
                        </td>
                        <td class="actions">
                            <a class="btn btn-primary" href="manage_products.php?id=<?php echo $row['product_id'] ?>">Edit</a>
                            <a class="btn btn-danger" href="products.php?action=delete&id=<?php echo $row['product_id'] ?>">Delete</a>
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