<?php
include '../db.php';
session_start();

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
}

if (isset($_GET['change_status'])) {
    $cheque_id = $_GET['change_status'];
    $new_status = ($_GET['status'] == 'approved') ? 0 : 1;
    $stmt = $conn->prepare("UPDATE cheques SET approved = ? WHERE id = ?");
    $stmt->execute([$new_status, $cheque_id]);
    $success_message = "Cheque status changed successfully!";
}

$pending_cheques = $conn->query("SELECT * FROM cheques")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Cheques</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <?php include('sidebar.php')?>
    <div class="content">
        <h2>Approve Cheques</h2>
        <?php if(isset($success_message)) { ?>
            <div class="alert alert-success" role="alert">
                <?= $success_message ?>
            </div>
        <?php } ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pending_cheques as $cheque): ?>
                    <tr>
                        <td><?= htmlspecialchars($cheque['user_id']) ?></td>
                        <td><?= htmlspecialchars($cheque['amount']) ?></td>
                        <td><?= ($cheque['approved'] == 1) ? 'Approved' : 'Not Approved' ?></td>
                        <td>
                            <a href="?change_status=<?= $cheque['id'] ?>&status=<?= ($cheque['approved'] == 1) ? 'approved' : 'not_approved' ?>" class="btn btn-<?php echo ($cheque['approved'] == 1) ? 'danger' : 'success'; ?> btn-sm">
                                <?php echo ($cheque['approved'] == 1) ? 'Reject' : 'Approve'; ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
