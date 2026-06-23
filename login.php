<?php
session_start();
include "db.php";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users 
    WHERE email='$email' AND password='$password'");

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];

        header("Location: dashboard.php");
    } else {
        echo "Invalid Login!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>Login</h2>

<form method="POST">
Email:
<input type="email" name="email" required>

Password:
<input type="password" name="password" required>

<button name="login">Login</button>
</form>

<p style="text-align:center;">
Don't have account? <a href="register.php">Register</a>
</p>

</div>
</body>
</html>