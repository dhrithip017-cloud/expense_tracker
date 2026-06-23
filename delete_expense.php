<?php
session_start();
include "db.php";

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$conn->query("DELETE FROM expenses WHERE id='$id' AND user_id='$user_id'");

header("Location: dashboard.php");
?>