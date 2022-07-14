<?php
session_start();

if (isset($_SESSION['USER_LOGGED']) && $_SESSION['USER_LOGGED'] == 'true') {

    unset($_SESSION['USER_LOGGED']);
    unset($_SESSION['USER_NAME']);
    unset($_SESSION['USER_ID']);

    ?>
    <script>
        window.location.href = 'index.php';
    </script>
    <?php
    
}else{
    ?>
    <script>
        window.location.href = 'index.php';
    </script>
<?php
}

?>