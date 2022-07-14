<?php

function get_safe_value($conn, $str)
{
    if ($str != '') {
        $str = trim($str);
        return mysqli_real_escape_string($conn, $str);
    }
}

function getCategory($conn, $cat_id = '')
{
    $sql = "SELECT * FROM categories WHERE cat_status=1";

    if ($cat_id != '') {
    }

    $result = mysqli_query($conn, $sql);
    return $result;
}

function getSubcategory($conn, $cat_id = '', $sub_cat_id = '')
{
    $sql = "SELECT * FROM sub_categories WHERE sub_cat_status=1 and cat_id='$cat_id'";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function getProducts($conn, $cat_id = '', $sub_cat_id = '', $product_id = '', $limit = '', $is_bestseller = '', $sortby = '',$search = '')
{
    $sql = "SELECT * FROM products,categories,sub_categories WHERE products.status='1' ";

    if ($product_id != '') {
        $sql .= " and products.product_id='$product_id'";
    }

    if ($cat_id != '') {
        $sql .= " and products.category_id='$cat_id'";
    }

    if ($sub_cat_id != '') {
        $sql .= " and products.sub_cat_id='$sub_cat_id'";
    }

    $sql .= " and products.category_id = categories.cat_id and categories.cat_id=sub_categories.cat_id and products.sub_cat_id=sub_categories.id";

    if ($is_bestseller != '') {
        $sql .= " and products.best_seller='1'";
    }

    if ($search != '') {
        $sql .= " and (products.name LIKE '%$search%' or products.short_desc LIKE '%$search%' or products.long_desc LIKE '%$search%')";
     }

    if ($sortby != '') {
        $sql .= $sortby;
    } else {
        $sql .= " ORDER BY products.product_id DESC";
    }

    if ($limit != '') {
        $sql .= " LIMIT " . $limit;
    }

    $result = mysqli_query($conn, $sql);

    $product_array = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $product_array[] = $row;
    }


    return $product_array;
}


class cart
{

    function addProduct($p_id, $qty)
    {
        $_SESSION['cart'][$p_id]['qty'] = $qty;
    }

    function upadteProduct($p_id, $qty)
    {
        if (isset($_SESSION['cart'][$p_id])){
            $_SESSION['cart'][$p_id]['qty'] = $qty;
        }
    }

    function removeProduct($p_id){
        unset($_SESSION['cart'][$p_id]);
    }

    function emptyCart(){
        unset($_SESSION['cart']);
    }

    function totalProduct(){
        if (isset($_SESSION['cart'])){
            return count($_SESSION['cart']);
        }
        else{
            return 0;
        }
    }

}


class Wishlist
{
    function totalProduct($conn,$user_id,$p_id){
        if ($p_id == ''){ 
            $sql = "SELECT * FROM wishlist WHERE `user_id`='$user_id'";

        }else{
            $sql = "SELECT * FROM wishlist WHERE `user_id`='$user_id' and product_id='$p_id'";
        }
        $result = mysqli_query($conn,$sql);
        return mysqli_num_rows($result);
    }

    function addProduct($conn,$user_id,$p_id){
        if ($this -> totalProduct($conn,$user_id,$p_id) == 0){
            $sql = "INSERT INTO `wishlist`(`user_id`, `product_id`) VALUES ('$user_id','$p_id')";
            mysqli_query($conn,$sql);
        }
    }

    function removeProduct($conn,$user_id,$p_id){
        $sql = "DELETE FROM wishlist WHERE `user_id`='$user_id' and `product_id`='$p_id'";
        mysqli_query($conn,$sql);
    }

}


function productSoldByProductId($conn, $p_id){
    $sql = "";
}