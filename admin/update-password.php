<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br />
        <br />
        <br />

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password:</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
// check whether the submit button is clicked or not

if (isset($_POST['submit'])) {
    //    get the data from form
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    // check whether the user with current id and current password exist or not
    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

    // execute the query
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        // check whether data is available or not
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            // check whether the new password and confirm password match or not
            if ($new_password == $confirm_password) {
                // update password
                $sql2 = "UPDATE tbl_admin SET
                password='$new_password'
                WHERE id=$id
                ";

                // execute the query
                $res2 = mysqli_query($conn, $sql2);

                if ($res2 == true) {
                    // display success msg
                    $_SESSION['change-password'] = "Password changed succesfully";
                    header("location:" . SITEURL . 'admin/manage-admin.php');
                } else {
                    // display error msg
                    $_SESSION['change-password'] = "Failed to change password";
                    header("location:" . SITEURL . 'admin/manage-admin.php');
                }
            } else {
                // redirect to manage admin page with error msg
                $_SESSION['password-not-match'] = "Password do not match";
                header("location:" . SITEURL . 'admin/manage-admin.php');
            }
        } else {
            $_SESSION['User-not-found'] = "User not found";
            header("location:" . SITEURL . 'admin/manage-admin.php');
        }
    }

    // check whether new password and confirm password match or not
    // change password
} else {
}

?>

<?php include('partials/menu.php'); ?>