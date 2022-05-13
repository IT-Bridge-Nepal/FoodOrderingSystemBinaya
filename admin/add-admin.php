<?php include('partials/menu.php'); ?>
<div class="main-content">

    <div class="wrapper">
        <h1>Add Admin</h1>
        <?php
        if (isset($_SESSION['add'])) //checking  whether the session is set or not
        {
            echo $_SESSION['add']; //display the session message if set
            unset($_SESSION['add']); //remove session message 
        }
        ?>
        <br />
        <br />
        <br />
        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full name:</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Your Username">
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="Your Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>

</div>
<?php include('partials/footer.php'); ?>

<?php
// process the value from form and save it to database


// check whether the button is clicked or not
if (isset($_POST['submit'])) {
    // button clicked
    // echo 'button clicked';

    // Get data from the form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //password encrypted with md5

    // SQL query to save tha data into database
    $sql = "INSERT INTO tbl_admin SET
    full_name = '$full_name',
    username = '$username',
    password = '$password'
    ";

    // execute query and save data in the database


    $res = mysqli_query($conn, $sql) or die(mysqli_error($e));

    // check whether the (Query is executed) data is inserted or not
    if ($res == true) {
        // create a session variable to display message
        $_SESSION['add'] = "Admin added succesfully";
        // redirect page to manage admin 
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        // create a session variable to display message
        $_SESSION['add'] = "Failed to add admin";
        // redirect page to add admin
        header("location:" . SITEURL . 'admin/add-admin.php');
    }
}

?>