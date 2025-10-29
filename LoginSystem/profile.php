<?php

    include "functions.php";

    check_login();

    if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['action']) && $_POST['action'] == 'post_delete') {
        $id = $_POST['id'] ?? $_GET['id'] ?? 0;
        $user_id = $_SESSION['info']['id'];

    $query = "SELECT * FROM posts WHERE id = '$id' AND user_id = '$user_id' limit 1";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            if (file_exists($row['image'])) {
                unlink($row['image']);
            }
        }

    $query = "DELETE FROM posts WHERE id = '$id' AND user_id = '$user_id' limit 1";
        $result = mysqli_query($con, $query);

        header("Location: profile.php");
        die;
    }

    elseif ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['action']) && $_POST['action'] == 'post_edit') {

        $id = $_POST['id'] ?? $_GET['id'] ?? 0;
        $user_id = $_SESSION['info']['id'];

        $image_added = false;
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
            $folder = "images/";
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            $image = $folder . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $image);

                $query = "SELECT * FROM posts WHERE id = '$id' AND user_id = '$user_id' limit 1";
                $result = mysqli_query($con, $query);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);

                    if (file_exists($row['image'])) {
                        unlink($row['image']);
                    }
                }

            $image_added = true;
        }

        $post = addslashes($_POST['post']);

        if ($image_added == true) {
            $query = "UPDATE posts SET post = '$post', image = '$image' WHERE id = '$id' AND user_id = '$user_id' limit 1";
        } else {
            $query = "UPDATE posts SET post = '$post' WHERE id = '$id' AND user_id = '$user_id' limit 1";
        }

        $result = mysqli_query($con, $query);

        header("Location: profile.php");
        die;
    }

    elseif ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_SESSION['info']['id'];
        $query = "DELETE FROM users WHERE id = '$id' limit 1";
        $result = mysqli_query($con, $query);

        if (file_exists($_SESSION['info']['image'])) {
            unlink($_SESSION['info']['image']);
        }

        $query = "DELETE FROM posts WHERE user_id = '$id'";
        $result = mysqli_query($con, $query);

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
            $query = "UPDATE users SET username = '$username', email = '$email', password = '$password' WHERE id = '$id' limit 1";
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

        elseif ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['post'])) {
        
        $image = "";
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
            $folder = "images/";
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            $image = $folder . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $image);

        }

        $post = addslashes($_POST['post']);
        $user_id = $_SESSION['info']['id'];
        $date = date('Y-m-d H:i:s');

        $query = "INSERT INTO posts (user_id, post, image, date) VALUES ('$user_id', '$post', '$image', '$date')";

        $result = mysqli_query($con, $query);

        header("Location: profile.php");
        die;
    }

?>

<?php include "header.php"; ?>

<div class="div-signup">

    <?php if (!empty($_GET['action']) && $_GET['action'] == 'post_delete' && !empty($_GET['id'])):?>

        <?php
            $id = (int)$_GET['id'];
            $query = "SELECT * FROM posts WHERE id = '$id' limit 1";
            $result = mysqli_query($con, $query);
        ?>

        <?php if(mysqli_num_rows($result) > 0):?>
            <?php $row = mysqli_fetch_assoc($result);?>

            <h5>Are you sure you want to delete this post?</h5>
            <form method="post" enctype="multipart/form-data">

                <img class="img-post2" src="<?=$row['image']?>"><br>
                <div><?=$row['post']?></div><br>
                <input type="hidden" name="action" value="post_delete">
                <input type="hidden" name="id" value="<?=$row['id']?>">

                <button>Delete</button>
                <a href="profile.php">
                    <button type="button">Cancel</button>
                </a>
        
            </form>
        <?php endif;?>

    <?php elseif (!empty($_GET['action']) && $_GET['action'] == 'post_edit' && !empty($_GET['id'])):?>

        <?php
            $id = (int)$_GET['id'];
            $query = "SELECT * FROM posts WHERE id = '$id' limit 1";
            $result = mysqli_query($con, $query);
        ?>

        <?php if(mysqli_num_rows($result) > 0):?>
            <?php $row = mysqli_fetch_assoc($result);?>

            <h5>Edit a Post</h5>
            <form method="post" enctype="multipart/form-data">

                <img class="img-post2" src="<?=$row['image']?>"><br>
                image: <input type="file" name="image"><br>
                <textarea name="post" rows="8"><?=$row['post']?></textarea><br>
                <input type="hidden" name="action" value="post_edit">
                <input type="hidden" name="id" value="<?=$row['id']?>">

                <button>Save</button>
                <a href="profile.php">
                    <button type="button">Cancel</button>
                </a>
        
            </form>
        <?php endif;?>

    <?php elseif (!empty($_GET['action']) && $_GET['action'] == 'edit'):?>

        <h2>Edit Profile</h2>
        <form method="post" enctype="multipart/form-data">
            <img src="<?php echo $_SESSION['info']['image']?>">
            Image: <input type="file" name="image"><br>
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
            <input type="hidden" name="action" value="delete">
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
                <td><img class="img-profile" src="<?php echo $_SESSION['info']['image']?>"></td>
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
        <form method="post" enctype="multipart/form-data">

            image: <input type="file" name="image"><br>
            <textarea name="post" rows="8"></textarea><br>

            <button>Post</button>
        </form>

        <hr>
        <posts>
            <?php
                $id = $_SESSION['info']['id'];
                $query = "SELECT * FROM posts WHERE user_id = '$id' ORDER BY id DESC";
                $result = mysqli_query($con, $query);
            ?>

            <?php if (mysqli_num_rows($result) > 0):?>

                <?php while ($row = mysqli_fetch_assoc($result)):?>

                    <?php
                        $user_id = $row['user_id'];
                        $query = "SELECT username, image FROM users WHERE id = '$user_id' limit 1";
                        $result2 = mysqli_query($con, $query);

                        $user_row = mysqli_fetch_assoc($result2);
                    ?>
                    <div class="post-border">
                        <div class="img-align1">
                            <img class="img-post1" src="<?=$user_row['image']?>">
                            <br>
                            <?=$user_row['username']?>
                        </div>
                        <div class="img-align2">
                            <?php if (file_exists($row['image'])):?>
                                <div style="">
                                    <img class="img-post2" src="<?=$row['image']?>">
                                </div>
                            <?php endif;?>
                            <div>
                                <div class="post-date"><?=date("jS M, Y", strtotime($row['date']))?></div>
                                <?php echo nl2br(htmlspecialchars($row['post']))?>

                                <br><br>

                                <a href="profile.php?action=post_edit&id=<?=$row['id']?>">
                                    <button>Edit</button>
                                </a>

                                <a href="profile.php?action=post_delete&id=<?=$row['id']?>">
                                    <button>Delete</button>
                                </a>
                                <br><br>
                            </div>
                        </div>
                    </div>
                <?php endwhile;?>
            <?php endif;?>
        </posts>
    <?php endif;?>

</div>

<?php include "footer.php"; ?>