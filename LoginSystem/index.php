<?php

    include "functions.php";

?>

<?php include "header.php"; ?>

    <div class="div-posts">

        <h3>Timeline</h3>
        <?php
            $query = "SELECT * FROM posts ORDER BY id DESC limit 10";

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
                            <?php echo $row['post']?>
                        </div>
                    </div>
                </div>
            <?php endwhile;?>
        <?php endif;?>
    </div>

<?php include "footer.php"; ?>