<?php

require 'partials/dbconnect.php';

$email_error = '';
$user_error = '';
$password_error = '';
$is_image_error = '';


if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);


    if ($_FILES['image']['type'] != '') {
        if ($_FILES['image']['type'] == 'image/png' || $_FILES['image']['type'] == 'image/jpg' || $_FILES['image']['type'] == 'image/jpeg') {
            $is_image_error = '';
        } else {
            $is_image_error = 'Please select an image with png, jpg or jpeg format only. Your file type is' . $_FILES['image']['type'];
        }
    }

    $sql = "SELECT * FROM admin_users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows == 0) {

        $sql = "SELECT * FROM admin_users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);

        if ($num_rows == 0) {

            if ($is_image_error == '') {

                if ($password == $cpassword) {

                    $image = $_FILES['image']['name'];
                    $tempname = $_FILES['image']['tmp_name'];
                    $folder = ADMIN_USER_IMAGE_PATH . $image;
                    move_uploaded_file($tempname, $folder);

                    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

                    $insert = "INSERT INTO admin_users (`username`, `email`, `phone_no`, `password`, `image`, `user_status`) 
                                VALUES ('$username','$email','$phone','$pass_hash','$image','1')";
                    mysqli_query($conn,$insert);

                    header('location: adminlogin.php');

                } else {
                    $password_error = 'Passwords must be same.';
                }
            }
        } else {
            $email_error  = 'Email already registerd.';
        }
    } else {
        $user_error = 'User already exists.';
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
    <link rel="stylesheet" href="style/register.css">
</head>

<body>
    <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <div class="head">
            <img class=" mt-3 mb-1" src="img/logo.png" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Register Admin User</h1>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Username" id="floatingInput" placeholder="Username" required>
                    <label for="floatingInput">Username</label>
                </div>
                <div>
                    <p class="error show"><?php echo $user_error; ?></p>
                </div>
            </div>

            <div class="col">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email" placeholder="email" id="floatingInput2" required>
                    <label for="floatingInput2">Email</label>
                </div>
                <div>
                    <p class="error show"><?php echo $email_error; ?></p>
                </div>
            </div>
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="phone" placeholder="phone" id="floatingInput3" required>
                    <label for="floatingInput3">Phone No.</label>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col">
                <div>
                    <label for="formFileLg" class="form-label">Upload User image</label>
                    <input name="image" class="form-control form-control-lg mb-3" id="formFileLg" type="file" required>
                </div>
                <div>
                    <p class="error show"><?php echo $is_image_error; ?></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>
                <div>
                    <p class="error show"><?php echo $password_error; ?></p>
                </div>
            </div>
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="cpassword" id="floatingPassword2" placeholder="Confirm password" required>
                    <label for="floatingPassword2">Confirm password</label>
                </div>
            </div>
        </div>

        <div class="row-btn">
            <button class="btn btn-lg btn-primary" type="submit">Register Admin</button>

        </div>
        <div class="head">
            <p class="mt-5 mb-3 text-muted">KEEPUFIT &copy; 2021</p>
        </div>
    </form>
</body>

</html>