<?php

    include "functions.php";

    check_login();

    if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_SESSION['info']['id'];
        $query = "DELETE FROM users WHERE id = '$id' limit 1";
        $result = mysqli_query($con, $query);

        if (file_exists($_SESSION['info']['image'])) {
            unlink($_SESSION['info']['image']);
        }

        header("Location: logout.php");
        die;
    }

    elseif ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['username'])) {
        
        $image_added = false;
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
            $folder = "images/";
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            $image = $folder . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $image);

            if (file_exists($_SESSION['info']['image'])) {
                unlink($_SESSION['info']['image']);
            }

            $image_added = true;
        }

        $username = addslashes($_POST['username']);
        $email = addslashes($_POST['email']);
        $password = addslashes($_POST['password']);
        $id = $_SESSION['info']['id'];

        if ($image_added == true) {
            $query = "UPDATE users SET username = '$username', email = '$email', password = '$password', image = '$image' WHERE id = '$id' limit 1";
        } else {
            $query = "UPDATE users SET username = '$username', email = '$email', password = '$password', WHERE id = '$id' limit 1";
        }

        $result = mysqli_query($con, $query);

        $query = "SELECT * FROM users WHERE id = '$id' limit 1";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['info'] = mysqli_fetch_assoc($result);   
        }
        

        header("Location: profile.php");
        die;
    }

?>

<?php include "header.php"; ?>

<div class="div-signup">

    <?php if (!empty($_GET['action']) && $_GET['action'] == 'edit'):?>

        <h2>Edit Profile</h2>
        <form method="post" enctype="multipart/form-data">
            <img src="<?php echo $_SESSION['info']['image']?>">
            Image: <input type="file" name="image" required><br>
            <input value="<?php echo $_SESSION['info']['username']?>" type="text" name="username" placeholder="Username" required><br>
            <input value="<?php echo $_SESSION['info']['email']?>" type="email" name="email" placeholder="Email" required><br>
            <input value="<?php echo $_SESSION['info']['password']?>" type="text" name="password" placeholder="Password" required><br>

            <button>Save</button>
            <a href="profile.php">
                <button type="button">Cancel</button>
            </a>
        </form>

    <?php elseif (!empty($_GET['action']) && $_GET['action'] == 'delete'):?>

    <h2>Are you sure you want to delete your profile?</h2>

    <div>
        <form method="post" enctype="multipart/form-data">
            <img src="<?php echo $_SESSION['info']['image']?>">
            <div><?php echo $_SESSION['info']['username']?></div>
            <div><?php echo $_SESSION['info']['email']?></div>

            <button>Delete</button>
            <a href="profile.php">
                <button type="button">Cancel</button>
            </a>    
        </form>
    </div>

    <?php else:?>

        <h2>User Profile</h2>
        <br>

        <div class="div-table">
            <div>
                <td><img src="<?php echo $_SESSION['info']['image']?>"></td>
            </div>
            <div>
                <td><?php echo $_SESSION['info']['username']?></td>
            </div>
            <div>
                <td><?php echo $_SESSION['info']['email']?></td>
            </div>

            <a href="profile.php?action=edit">
                <button>Edit Profile</button>
            </a>

            <a href="profile.php?action=delete">
                <button>Delete</button>
            </a>

        </div>
        <br>

        <hr>

        <h5>Create a Post</h5>
        <form method="post">
            <textarea name="post" rows="8"></textarea>

            <button>Post</button>
        </form>

    <?php endif;?>

</div>

<?php include "footer.php"; ?>