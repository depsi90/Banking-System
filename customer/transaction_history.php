<?php
include '../db.php';
session_start();

if ($_SESSION['role'] != 'customer') {
    header("Location: login.php");
}

// Fetch user transactions
$transactions = $conn->prepare("SELECT * FROM transactions WHERE user_id = ?");
$transactions->execute([$_SESSION['user_id']]);
$user_transactions = $transactions->fetchAll();

// Calculate balance
$balance = 0;
foreach ($user_transactions as $transaction) {
    $balance += ($transaction['type'] == 'credit') ? $transaction['amount'] : -$transaction['amount'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS to color transaction types */
        .credit { color: green; }
        .debit { color: red; }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="container">
        <h2 class="mt-3">Transaction History</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($user_transactions as $transaction): ?>
                        <tr>
                            <td class="<?= ($transaction['type'] == 'credit') ? 'credit' : 'debit' ?>">
                                <?= htmlspecialchars($transaction['type']) ?>
                            </td>
                            <td><?= htmlspecialchars($transaction['amount']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Display balance after the table -->
        <div class="mb-3">
            <strong>Balance: <?= $balance ?></strong>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
