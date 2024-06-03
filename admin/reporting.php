<?php
include '../db.php';

$today = date('Y-m-d');
$reportDirectory = 'reports';
$reportFilePath = "$reportDirectory/report_$today.txt";


if (!file_exists($reportDirectory)) {
    if (!mkdir($reportDirectory, 0777, true)) {
        die('Failed to create reports directory.');
    }
}

$stmt = $conn->prepare("SELECT * FROM transactions WHERE DATE(created_at) = ?");
$stmt->execute([$today]);
$daily_transactions = $stmt->fetchAll();

if (!$daily_transactions) {
    die('No transactions found for today.');
}

$report = "Daily Report for $today:\n";
foreach ($daily_transactions as $transaction) {
    $report .= "User ID: {$transaction['user_id']}, Type: {$transaction['type']}, Amount: {$transaction['amount']}\n";
}

// Write the report to the file
if (file_put_contents($reportFilePath, $report) === false) {
    die('Failed to write report to file.');
}

echo 'Report generated successfully.';
?>
