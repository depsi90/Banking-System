<?php
include '../db.php';
session_start();

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
}

$transactions = $conn->query("SELECT * FROM transactions")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Reports</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
   
</head>
<body>
<?php include('sidebar.php')?>
    <div class="content">
        <h2>Transaction Reports</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Type</th>
                    <th scope="col">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?= htmlspecialchars($transaction['user_id']) ?></td>
                        <td class="<?= ($transaction['type'] == 'credit') ? 'text-success' : 'text-danger' ?>">
                            <?= htmlspecialchars($transaction['type']) ?>
                        </td>
                        <td><?= htmlspecialchars($transaction['amount']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
