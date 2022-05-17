<?php
// include constants file
include('../config/constants.php');
// echo 'Delete page.';
// check whether the id and image_name value is set or not
if (isset($_GET['id']) && isset($_GET['image_name'])) {
    // get the value and delete
    // echo 'get value and delete';
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
    // remove the physical image if available
    if ($image_name != "") {
        // image is available and remove it
        $path = '../images/food/' . $image_name;
        // remove the image
        $remove = unlink($path);

        // if failed to remove image then display error msg and stop the process
        if ($remove == false) {
            // set the session msg
            $_SESSION['remove'] = "Failed to remove food image";
            // redirect to manage category page
            header('location:' . SITEURL . 'admin/manage-food.php');
            // stop the process
            die;
        }
    }

    // delete data from database 
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    // ececute the query
    $res = mysqli_query($conn, $sql);

    // check whether the data is deleted from database or not
    if ($res == true) {
        // set success msg and redirect
        $_SESSION['delete'] = "Food deleted succesfully";
        header('location:' . SITEURL . 'admin/manage-food.php');
    } else {
        // set failed msg and redirect
        $_SESSION['delete'] = 'Failed to delete food';
        header('location:' . SITEURL . 'admin/manage-food.php');
    }
    // redirect to manage category page


} else {
    // redirect to manage category page 
    header('location:' . SITEURL . 'admin/manage-food.php');
}
