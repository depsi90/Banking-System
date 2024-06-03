<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #f8f9fa;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Dashboard</h3>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="admin/approve_users.php">Approve Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin/approve_cheques.php">Approve Cheques</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin/transaction_reports.php">Transaction Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin/reporting.php">Reporting</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
        </ul>
    </div>
    <div class="content" style="margin-left: 250px; padding: 20px;">
        <h1>Welcome to Admin Dashboard</h1>
     
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
