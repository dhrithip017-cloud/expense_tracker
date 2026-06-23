<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$month = date('m');
$year = date('Y');

// Monthly total
$total = $conn->query("
SELECT SUM(amount) as total 
FROM expenses 
WHERE user_id='$user_id' 
AND MONTH(expense_date)='$month'
AND YEAR(expense_date)='$year'
");

$row = $total->fetch_assoc();
$monthly_total = $row['total'] ?? 0;

// Category-wise monthly data for chart
$chart_data = $conn->query("
SELECT category, SUM(amount) as total 
FROM expenses 
WHERE user_id='$user_id' 
AND MONTH(expense_date)='$month'
AND YEAR(expense_date)='$year'
GROUP BY category
");

$categories = [];
$amounts = [];

while($data = $chart_data->fetch_assoc()){
    $categories[] = $data['category'];
    $amounts[] = $data['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link rel="stylesheet" href="style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">

<div class="logout">
<a href="logout.php">Logout</a>
</div>

<h2>Welcome <?php echo $_SESSION['name']; ?> 👋</h2>

<h3>Add Expense</h3>

<form action="add_expense.php" method="POST">
Amount:
<input type="number" step="0.01" name="amount" required>

Category:
<input type="text" name="category" required>

Date:
<input type="date" name="expense_date" required>

<button>Add Expense</button>
</form>

<div class="total-box">
 Total Amount: ₹ <?php echo $monthly_total; ?>
</div>

<h3>Monthly Expense Chart 📊</h3>
<canvas id="expenseChart"></canvas>

<script>
const ctx = document.getElementById('expenseChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($categories); ?>,
        datasets: [{
            label: 'Expense Amount',
            data: <?php echo json_encode($amounts); ?>,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<h3>Your Expenses</h3>

<table>
<tr>
<th>Date</th>
<th>Category</th>
<th>Amount</th>
<th>Action</th>
</tr>

<?php
$expenses = $conn->query("SELECT * FROM expenses WHERE user_id='$user_id' ORDER BY expense_date DESC");

while($e = $expenses->fetch_assoc()){
    echo "<tr>
    <td>{$e['expense_date']}</td>
    <td>{$e['category']}</td>
    <td>₹ {$e['amount']}</td>
    <td>
    <a href='edit_expense.php?id={$e['id']}'>Edit</a> |
    <a href='delete_expense.php?id={$e['id']}'>Delete</a>
    </td>
    </tr>";
}
?>
</table>

<h3>💡 Motivation</h3>
<table>
<tr><td>Save at least 20% of your income 💰</td></tr>
<tr><td>Track daily = Control monthly 📊</td></tr>
<tr><td>Small savings today = Big future 🚀</td></tr>
</table>

</div>
</body>
</html>