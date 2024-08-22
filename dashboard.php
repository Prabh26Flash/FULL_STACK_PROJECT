<?php
session_start();
include("db_connect.php");

// Redirect to login page if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch user details for greeting
$userQuery = mysqli_query($conn, "SELECT firstName, lastName FROM user WHERE email='$email'");
$userData = mysqli_fetch_assoc($userQuery);
$fullName = $userData['firstName'] . ' ' . $userData['lastName'];

// Handle expense form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addExpense'])) {
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);

    $insertExpense = "INSERT INTO expenses (user_email, description, amount) VALUES ('$email', '$description', '$amount')";
    if (mysqli_query($conn, $insertExpense)) {
        $message = "Expense '$description' has been added.";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Fetch all expenses for the user
$expensesQuery = mysqli_query($conn, "SELECT description, amount FROM expenses WHERE user_email='$email'");
$expenses = mysqli_fetch_all($expensesQuery, MYSQLI_ASSOC);

// Calculate total expenses
$totalAmount = 0;
foreach ($expenses as $expense) {
    $totalAmount += $expense['amount'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/style1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    
</head>
<body>
    <div style="text-align:center; padding:15%;">
        <p style="font-size:20px; font-weight:bold; color:brown;">
            HELLO, <?php echo htmlspecialchars($fullName); ?>!<br>
           HERE IS YOUR EXPENSE TRACKER !
        </p>

        <div class="container">
            <h1>Expense Tracker</h1>
            <form method="post">
                <input type="text" class="form-control" name="description" id="description" placeholder="Description" required><br>
                <input type="number" class="form-control" name="amount" id="amount" placeholder="Amount" required>
                <br>
                <button type="submit"  class="btn btn-success" name="addExpense">Add Expense</button>
            </form>
            <br>

            <?php if (isset($message)): ?>
                <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
            <?php endif; ?>

            <h2>Expenses</h2>
            <ul>
                <?php foreach ($expenses as $expense): ?>
                    <li><?php echo htmlspecialchars($expense['description']); ?> - 💵<?php echo number_format($expense['amount'], 2); ?></li>
                <?php endforeach; ?>
            </ul>

            <h2>Total: 💵<span><?php echo number_format($totalAmount, 2); ?></span></h2>
        </div>
        <br>

        <div>
            <button type="button" class="btn btn-primary" onclick="viewExpenses()">View Expenses</button>
        </div>
        <br>


        <a href="logout.php"><button type="button" class="btn btn-danger">Logout</button></a>
    </div>

    <script src="js/scripts.js"></script>
    <script src="js/script1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
