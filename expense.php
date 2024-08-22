<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $email = $_SESSION['email'];

    $stmt = $conn->prepare("INSERT INTO expenses (user_email, description, amount) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $email, $description, $amount);

    if ($stmt->execute()) {
        $message = "Expense added successfully.";
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Expense</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Add a New Expense</h2>
        <?php if (isset($message)) { echo "<p style='color:green;'>$message</p>"; } ?>
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <form method="POST" action="expense.php">
            <div class="input-group">
                <i class="fas fa-align-left"></i>
                <input type="text" name="description" placeholder="Description" required>
                <label for="description">Description</label>
            </div>
            <div class="input-group">
                <i class="fas fa-dollar-sign"></i>
                <input type="number" name="amount" placeholder="Amount" step="0.01" required>
                <label for="amount">Amount</label>
            </div>
            <button type="submit" class="btn">Add Expense</button>
        </form>
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>
