<?php include('partials/menu.php'); ?>
<?php include('../config/constants.php'); ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br />
        <br />
        <?php
        if (isset($_SESSION['add'])) //checking  whether the session is set or not
        {
            echo $_SESSION['add']; //display the session message if set
            unset($_SESSION['add']); //remove session message 
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>
        <br />
        <br />
        <!-- add category form starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Category Title"></td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td><input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td><input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Add Categotry" class="btn-secondary"></td>
                </tr>
            </table>
        </form>
        <!-- add category form ends -->

    </div>
</div>

<?php include('partials/footer.php'); ?>
<?php
// check whether the submit button id clicked or not
if (isset($_POST['submit'])) {
    //echo 'button clicked';
    // get the value fron the form
    $title = $_POST['title'];
    // for radio input type we need to check whether the button i selected or not
    if (isset($_POST['featured'])) {
        // get the value from the form
        $featured = $_POST['featured'];
    } else {
        //set the default value
        $featured = "No";
    }
    if (isset($_POST['active'])) {
        // get the value from the form
        $active = $_POST['active'];
    } else {
        //set the default value
        $active = "No";
    }

    // check whether the image is selected or not and set the value for image name accordingly

    if (isset($_FILES['image']['name'])) {
        // upload the image 
        // to upload image we need image name, source path and destination path
        $image_name = $_FILES['image']['name'];

        // upload image if only inage is selected
        if ($image_name != '') {

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

            // var_dump($upload);
            // die();
            // check whether the image is uploaded or not
            // if not uploaded we will stop the process and redirect with error msg
            if ($upload == FALSE) {
                // set session msg
                $_SESSION['upload'] = "Failed to upload image";
                header('location:' . SITEURL . 'admin/add-category.php');
                die();
            }
        }
    } else {
        // dont upload image and set the image name blank
        $image_name = '';
    }

    // create sql query to insert category into databases
    $sql = "INSERT INTO tbl_category SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            ";

    // execute the query
    $res = mysqli_query($conn, $sql);

    if ($res == TRUE) {
        $_SESSION['add'] = "Category added succesfully";
        header('location:' . SITEURL . 'admin/manage-category.php');
    } else {
        $_SESSION['add'] = "Category could not be added";
        header('location:' . SITEURL . 'admin/add-category.php');
    }
}

?>