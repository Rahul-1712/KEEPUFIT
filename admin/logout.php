<?php
    
    require 'partials/dbconnect.php';

    unset($_SESSION['LOGGED_IN']);
    unset($_SESSION['ADMIN_USERNAME']);

    header('location: adminlogin.php');
?>