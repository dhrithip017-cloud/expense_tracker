<?php
session_start();
include "db.php";

$user_id = $_SESSION['user_id'];

$amount = $_POST['amount'];
$category = $_POST['category'];
$date = $_POST['expense_date'];

$conn->query("INSERT INTO expenses (user_id,amount,category,expense_date)
VALUES ('$user_id','$amount','$category','$date')");

header("Location: dashboard.php");
?>