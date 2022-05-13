<?php include('partials/menu.php'); ?>


<!-- Main section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if (isset($_SESSION['User-not-found'])) {
            echo $_SESSION['User-not-found'];
            unset($_SESSION['User-not-found']);
        }
        if (isset($_SESSION['password-not-match'])) {
            echo $_SESSION['password-not-match'];
            unset($_SESSION['password-not-match']);
        }

        if (isset($_SESSION['change-password'])) {
            echo $_SESSION['change-password'];
            unset($_SESSION['change-password']);
        }

        ?>
        <br />
        <br />
        <br />
        <!-- button to add admin -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br />
        <br />
        <br />
        <?php
        if (isset($_SESSION['add']))
        ?>
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
            <?php
        // query to get all admin
        $sql =  "SELECT * FROM tbl_admin";
        // execute the query
        $res = mysqli_query($conn, $sql);
        // check whether the query is executed or not
        if ($res == TRUE) {
            // count rows to check whether we have data in database or not
            $count = mysqli_num_rows($res); //function to get all the data in database

            $sn = 1; //create a variable and assign the value

            if ($count > 0) {
                //we have data in database
                while ($rows = mysqli_fetch_assoc($res)) {
                    // using while loop to get all the data in database
                    // while loop will run as long as we have data in the database

                    // get individual data
                    $id = $rows['id'];
                    $full_name = $rows['full_name'];
                    $username = $rows['username'];
                    // display the values in table

            ?>
                        <tr>
                            <td><?php echo $sn++ ?></td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id ?>" class="btn-primary">Change Password</a>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id ?>" class="btn-secondary">Update admin</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id ?>" class="btn-danger">Delete admin</a>
                            </td>
                        </tr>
            <?php

                }
            } else {
                //we do not have data in database
            }
        }
            ?>

        </table>

    </div>
</div>
<!-- Main section ends -->
<?php include('partials/footer.php'); ?>