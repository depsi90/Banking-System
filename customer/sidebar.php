<!-- sidebar.php -->
<div class="sidebar">
    <h2>Dashboard</h2>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="transactions.php">Transactions</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="submit_cheque.php">Submit Cheque</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="transaction_history.php">Transaction History</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../logout.php">Logout</a>
        </li>
    </ul>
</div>
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
    .content {
        margin-left: 250px;
        padding: 20px;
    }
</style>
