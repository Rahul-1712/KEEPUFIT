<?php

require '../partials/_dbconnect.php';

$is_error = '';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM admin_users WHERE username='$username'";
    $result = mysqli_query($conn,$sql);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows == 0 ) {
        $is_error = 'User does not exists';
    }else{


        $row = mysqli_fetch_assoc($result);
        if (password_verify($password,$row['password'])){
            $_SESSION['LOGGED_IN'] = true;
            $_SESSION['ADMIN_USERNAME'] = $username;
            header('location: index.php');
            
        }else{
            $is_error = 'Incorrect password';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Admin Login</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="style/login.css">
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <img class=" mt-3 mb-1" src="img/logo.png" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username" id="floatingInput" placeholder="Username">
            <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <div>
            <p class="error show"><?php echo $is_error; ?></p>
        </div>
        <button class="btn btn-lg btn-primary" type="submit" id="signin_btn">Sign in</button>
        <p class="mt-5 mb-3 text-muted">KEEPUFIT &copy; 2021</p>
    </form>
</body>

</html>