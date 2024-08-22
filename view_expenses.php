<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}

$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT description, amount, created_at FROM expenses WHERE user_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($description, $amount, $created_at);

$expenses = [];
while ($stmt->fetch()) {
    $expenses[] = ['description' => $description, 'amount' => $amount, 'created_at' => $created_at];
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Expenses</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Your Expenses</h2>
        <?php if (count($expenses) > 0): ?>
            <table>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
                <?php foreach ($expenses as $expense): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($expense['description']); ?></td>
                        <td><?php echo htmlspecialchars($expense['amount']); ?></td>
                        <td><?php echo htmlspecialchars($expense['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No expenses recorded.</p>
        <?php endif; ?>
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>
    <script src="js/scripts.js"></script>
    <script src="js/script1.js" ></script>
</body>
</html>
