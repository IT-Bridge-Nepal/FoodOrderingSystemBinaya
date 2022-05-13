<?php
// include constants.php file
include('../config/constants.php');
// get the id of admin to be deleted
$id = $_GET['id'];
// sql query to delete admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

// execute th query
$res = mysqli_query($conn, $sql);

// check whether the query executed succesfully or not
if ($res == true) {
    // query executed and admin deleted 
    // create session variable to display message
    $_SESSION['delete'] = "Admin deleted succesfully.";
    // redirect to manage admin page
    header('location:' . SITEURL . 'admin/manage-admin.php');
} else {
    // failed to delete admin
    $_SESSION['delete'] = 'Failed to delete admin.';
    header('location:' . SITEURL . 'admin/manage-admin.php');
}
// redirect to manage admin page with msg
