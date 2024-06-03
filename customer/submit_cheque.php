<?php
include '../db.php';
session_start();

if ($_SESSION['role'] != 'customer') {
    header("Location: index.php");
}

// Check if the form for submitting a cheque is submitted
if (isset($_POST['submit_cheque'])) {
    $amount = $_POST['amount'];
    $user_id = $_SESSION['user_id'];

    // Insert the cheque into the database
    $stmt = $conn->prepare("INSERT INTO cheques (user_id, amount) VALUES (?, ?)");
    $success = $stmt->execute([$user_id, $amount]);

    // Check if the insertion was successful
    if ($success) {
        $success_message = "Cheque submitted successfully!";
    } else {
        $error_message = "Failed to submit cheque.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Cheque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h2>Submit Cheque</h2>

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

        <!-- Form for submitting a cheque -->
        <form method="POST" action="">
            Amount: <input type="number" name="amount" class="form-control" required>
            <button type="submit" name="submit_cheque" class="btn btn-primary mt-2">Submit Cheque</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
