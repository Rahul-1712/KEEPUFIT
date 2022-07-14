<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "keepufit");

if (!$conn) {
    die(mysqli_connect_error());
}

define('SERVER_ROOT_PATH',$_SERVER['DOCUMENT_ROOT'].'/keepufit/');

define('SITE_ROOT_PATH','http://localhost/keepufit/');

define('SERVER_ADMIN_PATH', SERVER_ROOT_PATH.'admin/');
define('SITE_ADMIN_PATH', SITE_ROOT_PATH.'admin/');

define('ADMIN_USER_IMAGE_PATH', SERVER_ADMIN_PATH.'img/');
define('ADMIN_USER_IMAGE_SITE_PATH', SITE_ADMIN_PATH.'img/');


define('PRODUCT_IMAGE_SERVER_PATH',SERVER_ROOT_PATH.'assets/img/');
define('PRODUCT_IMAGE_SITE_PATH',SITE_ROOT_PATH.'assets/img/');

?>