<?php
include '../db.php';
session_start();

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
}

if (isset($_GET['change_status'])) {
    $user_id = $_GET['change_status'];
    $new_status = ($_GET['status'] == 'approve') ? 1 : 0;
    $stmt = $conn->prepare("UPDATE users SET approved = ? WHERE id = ?");
    $stmt->execute([$new_status, $user_id]);
    $success_message = "User status changed successfully!";
}

$users = $conn->query("SELECT * FROM users WHERE role = 'customer'")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>
    <?php include('sidebar.php')?>
    <div class="content">
        <h2>Manage Users</h2>
        <?php if(isset($success_message)) { ?>
            <div class="alert alert-success" role="alert">
                <?= $success_message ?>
            </div>
        <?php } ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= ($user['approved'] == 1) ? 'Approved' : 'Not Approved' ?></td>
                        <td>
                            <a href="?change_status=<?= $user['id'] ?>&status=<?= ($user['approved'] == 1) ? 'reject' : 'approve' ?>" class="btn btn-<?php echo ($user['approved'] == 1) ? 'danger' : 'success'; ?> btn-sm">
                                <?php echo ($user['approved'] == 1) ? 'Reject' : 'Approve'; ?>
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
