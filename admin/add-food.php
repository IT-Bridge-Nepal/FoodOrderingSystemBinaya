<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>
        <br />
        <br />
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the food."></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" placeholder="Price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php
                            // create php code to display categories from the database
                            // create sql to display all the active category from the database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);

                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                // we have data
                                while ($row = mysqli_fetch_assoc($res)) {
                                    // get the details of category
                                    $id = $row['id'];
                                    $title = $row['title'];
                            ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                <?php
                                }
                            } else {
                                // we dont have data
                                ?>
                                <option value="0">No categories found. </option>
                            <?php
                            }
                            // display on dropdown
                            ?>

                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php

// check whether the button is clickrd or not
if (isset($_POST['submit'])) {

    // add the food in database
    // get the data from form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    // check whether the radio button for featured and active is checked
    if (isset($_POST['featured'])) {
        $featured = $_POST['featured'];
    } else {
        $featured = "No";
    }

    if (isset($_POST['active'])) {
        $active = $_POST['active'];
    } else {
        $active = "No";
    }

    // upload the image if selected
    // check whether select button is clicked and upload image only if the image is selected
    if (isset($_FILES['image']['name'])) {
        // get the details of the selected image
        $image_name = $_FILES['image']['name'];
        // check whether the image is selected or not and upload the image only if selected
        if ($image_name != '') {
            // image is selected
            // rename the image
            // get the extension of the image
            $ext = end(explode('.', $image_name));
            // create new image name
            $image_name = "Food-name" . rand(000, 999) . '.' . $ext;
            //upload the image 
            // get the source path and destination path
            $source = $_FILES['image']['tmp_name'];
            $des = "../images/food/" . $image_name;
            // finally upload the image
            $upload = move_uploaded_file($source, $des);
            // check whether image uploaded or not
            if ($upload = false) {
                // failed to upload image
                // redirect to add-food page with error msg
                $_SESSION['upload'] = "Failed to upload image";
                header('location:' . SITEURL . 'admin/add-food.php');
                // stop the process
                die;
            }
        } else {
            // set default value as blank
            $image_name = "";
        }
    }
    // insert into database
    // create sql query to add or save food
    $sql2 = "INSERT INTO tbl_food SET
    title = '$title',
    description = '$description',
    price = $price,
    image_name = '$image_name',
    category_id = $category,
    featured = '$featured',
    active = '$active'
    ";

    // execute the query
    $res2 = mysqli_query($conn, $sql2);
    // check whether data is inserted or not
    // redirect with msg to manage food page

    if ($res2 == true) {
        // data inserted succesfully
        $_SESSION['add'] = "Food added succesfully.";
        header('location:' . SITEURL . 'admin/manage-food.php');
    } else {
        // failed to insert data
        $_SESSION['add'] = "Failed to add food.";
        header('location:' . SITEURL . 'admin/manage-food.php');
    }
}

?>