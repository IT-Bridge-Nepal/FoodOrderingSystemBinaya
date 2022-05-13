<?php include('../config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br />
        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>
        <br />
        <br />
        <!-- login form starts -->
        <form action="" method="POST" class="text-center">
            Username:
            <input type="text" name="username" placeholder="Enter Username"><br><br>

            Password:
            <input type="password" name="password" placeholder="Enter password"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary">

        </form>
        <!-- login form ends -->
        <br />
        <br />
        <p class="text-center">Created by - <a href=""><strong>Binaya Sharma</strong></a></p>
    </div>
</body>

</html>

<?php
// check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
    // process for login
    // get the data from login form
    $username = $_POST['username'];
    $password  = md5($_POST['password']);
    // sql query to check whether the user with username and password exist or not
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    // execute the query
    $res = mysqli_query($conn, $sql);

    $count = mysqli_num_rows($res);
    if ($count == 1) {
        // user available
        $_SESSION['login'] = "Logged in Succesfully.";

        $_SESSION['user'] = $username; //to check whether the user is logged in or not

        header('location:' . SITEURL . 'admin/index.php');
    } else {
        // user not available
        $_SESSION['login'] = "<div class='text-center'> Invalid Username And Password</div> ";
        header('location:' . SITEURL . 'admin/login.php');
    }
}

?>