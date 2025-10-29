<?php

    include "functions.php";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = addslashes($_POST['email']);
        $password = addslashes($_POST['password']);
        $date = date('Y-m-d H:i:s');

        $query = "SELECT * FROM users WHERE email = '$email' && password = '$password' limit 1";

        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $_SESSION['info'] = $row;
            header ("Location: profile.php");
            die;
        } else {
            $error = "Wrong Email or Password";
        }
    }

?>

<?php include "header.php"; ?>

<div class="div-signup">

    <?php
        if (!empty($error)) {
            echo "<div>".$error."</div>";
        }
    ?>

    <h2>Login</h2>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="password" placeholder="Password" required><br>

        <button>SignUp</button>
    </form>
</div>

<?php include "footer.php"; ?>