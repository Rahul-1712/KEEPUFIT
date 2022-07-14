<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "keepufit");

if (!$conn) {
    die(mysqli_connect_error());
}

define('SERVER_ROOT_PATH',$_SERVER['DOCUMENT_ROOT'].'/keepufit');

define('SITE_ROOT_PATH','http://localhost/keepufit/');

define('SITE_ADMIN_PATH', SITE_ROOT_PATH.'/admin');

define('PRODUCT_IMAGE_SERVER_PATH',SERVER_ROOT_PATH.'assets/img/');
define('PRODUCT_IMAGE_SITE_PATH',SITE_ROOT_PATH.'assets/img/');

?>