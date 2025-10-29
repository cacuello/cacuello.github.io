<?php

    include "functions.php";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = addslashes($_POST['username']);
        $email = addslashes($_POST['email']);
        $password = addslashes($_POST['password']);
        $date = date('Y-m-d H:i:s');

        $query = "INSERT INTO users (username, email, password, date) VALUES ('$username', '$email', '$password', '$date')";

        $result = mysqli_query($con, $query);

        header("Location: login.php");
        die;
    }

?>

<?php include "header.php"; ?>

<div class="div-signup">
    <h2>Sign Up</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="password" placeholder="Password" required><br>

        <button>SignUp</button>
    </form>
</div>

<?php include "footer.php"; ?>