<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login System</title>
</head>
<body>

<header>
    <div><a href="home.php">Home</a></div>
    <div><a href="profile.php">Profile</a></div>

    <?php if(empty($_SESSION['info'])):?>
        <div><a href="login.php">Login</a></div>
        <div><a href="signup.php">SignUp</a></div>
    <?php else:?>
        <div><a href="logout.php">LogOut</a></div>
    <?php endif;?>
    
</header>