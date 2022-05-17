<?php include("../config/constants.php"); ?>
<?php

if (isset($_POST['submit'])) {
    // get all the values from the form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    // var_dump($current_image);
    // die;

    // updating new image if selected

    // check whether the image is selected or not
    if (isset($_FILES['image']['name'])) {
        // get the image details
        $image_name = $_FILES['image']['name'];

        // check whether the image is available or not
        if ($image_name != "") {
            // image is available
            // upload the new image

            // auto rename image
            // get extension if the image(.jpg, .png, .gif etc)
            $ext = end(explode('.', $image_name));

            // rename the image
            $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;

            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../images/category/" . $image_name;

            // var_dump($destination_path);
            // die;
            // finally upload the file
            $upload = move_uploaded_file($source_path, $destination_path);


            // check whether the image is uploaded or not
            // if not uploaded we will stop the process and redirect with error msg
            if ($upload == FALSE) {
                // set session msg
                $_SESSION['upload'] = "Failed to upload image";
                header('location:' . SITEURL . 'admin/manage-category.php');
                die();
            }

            // remove the current image if available
            // if (array_key_exists('current_image', $_POST)) {
            //     $filename = $_POST['current_image'];
            //     var_dump($filename);
            //     die;
            //     // if (file_exists($filename)) {
            //     unlink($filename);
            //     // }
            // }
            if ($current_image != '') {
                // image is available and remove it
                // unlink($current_image);
                $path = '../images/category/' . $current_image;

                // var_dump($path);
                // die();
                // remove the image
                $remove = unlink($path);

                // if failed to remove image then display error msg and stop the process
                if ($remove == false) {
                    // set the session msg
                    $_SESSION['failed-remove'] = "Failed to remove category image";
                    // redirect to manage category page
                    header('location:' . SITEURL . 'admin/manage-category.php');
                    // stop the process
                    die;
                }
            }
        } else {
            $image_name = $current_image;
        }
    } else {
        $image_name = $current_image;
    }

    // update the database
    $sql2 = "UPDATE tbl_category SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            WHERE id=$id 
            ";

    // execute the query
    $res2 = mysqli_query($conn, $sql2);

    // redirect to manage category with msg
    // check whether query executed or not
    if ($res2 == true) {
        // category updated
        $_SESSION['update'] = "Category updated succesfully.";
        header('location:' . SITEURL . 'admin/manage-category.php');
    } else {
        // failed to update category
        $_SESSION['update'] = "Failed to update category.";
        header('location:' . SITEURL . 'admin/manage-category.php');
    }
}
