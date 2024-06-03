<?php
include '../db.php';
session_start();

if ($_SESSION['role'] != 'customer') {
    header("Location: index.php");
}

function calculateBalance($transactions) {
    $balance = 0;
    foreach ($transactions as $transaction) {
        if ($transaction['type'] == 'credit') {
            $balance += $transaction['amount'];
        } else {
            $balance -= $transaction['amount'];
        }
    }
    return $balance;
}

$transactionsQuery = $conn->prepare("SELECT * FROM transactions WHERE user_id = ?");
$transactionsQuery->execute([$_SESSION['user_id']]);
$user_transactions = $transactionsQuery->fetchAll();

$balance = calculateBalance($user_transactions);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $amount = $_POST['amount'];

    if ($type == 'debit' && $amount > $balance) {
        $error_message = "Insufficient balance";
    } else {
        $user_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("INSERT INTO transactions (user_id, type, amount) VALUES (?, ?, ?)");
        $success = $stmt->execute([$user_id, $type, $amount]);
        if ($success) {
            $success_message = "Transaction submitted successfully!";
        } else {
            $error_message = "Failed to submit transaction.";
        }
      
        header("Location: transactions.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h2>Transactions</h2>
        <!-- Display balance -->
        <p>Balance: <?php echo $balance; ?></p>
        
        <!-- Display success or error message -->
        <?php if(isset($success_message)) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php } elseif(isset($error_message)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php } ?>

        <!-- Form for submitting transactions -->
        <form method="POST" action="">
            Type:
            <select name="type" class="form-select" required>
                <option value="credit">Credit</option>
                <option value="debit">Debit</option>
            </select>
            Amount: <input type="number" name="amount" class="form-control" required>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
