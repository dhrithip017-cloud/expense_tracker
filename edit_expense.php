<?php
session_start();
include "db.php";

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$result = $conn->query("SELECT * FROM expenses WHERE id='$id' AND user_id='$user_id'");
$expense = $result->fetch_assoc();

if(isset($_POST['update'])){
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $date = $_POST['expense_date'];

    $conn->query("UPDATE expenses SET 
        amount='$amount',
        category='$category',
        expense_date='$date'
        WHERE id='$id' AND user_id='$user_id'");

    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Expense</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>Edit Expense</h2>

<form method="POST">
Amount:
<input type="number" step="0.01" name="amount" value="<?php echo $expense['amount']; ?>" required>

Category:
<input type="text" name="category" value="<?php echo $expense['category']; ?>" required>

Date:
<input type="date" name="expense_date" value="<?php echo $expense['expense_date']; ?>" required>

<button name="update">Update</button>
</form>

</div>
</body>
</html>