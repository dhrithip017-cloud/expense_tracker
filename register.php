<?php
include "db.php";

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn->query("INSERT INTO users (name,email,password) 
    VALUES ('$name','$email','$password')");

    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>Register</h2>

<form method="POST">
Name:
<input type="text" name="name" required>

Email:
<input type="email" name="email" required>

Password:
<input type="password" name="password" required>

<button name="register">Register</button>
</form>

<p style="text-align:center;">
Already have account? <a href="login.php">Login</a>
</p>

</div>
</body>
</html>