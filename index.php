<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Debugging: Log input
    error_log("Username: $username");

    // Prepare and execute the statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debugging: Log fetched user data
    error_log("Fetched user: " . print_r($user, true));

    // Check if the user exists and if the password is correct
    if ($user && password_verify($password, $user['password']) && $user['approved']) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];

        // Debugging: Log user role
        error_log("User role: " . $user['role']);

        // Redirect based on the role
        if ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php");
            exit();
        } else {
            header("Location: customer_dashboard.php");
            exit();
        }
    } else {
        // Display error message
        echo "Invalid credentials or account not approved.";
        // Debugging: Log error reason
        if (!$user) {
            error_log("User not found.");
        } elseif (!password_verify($password, $user['password'])) {
            error_log("Password incorrect.");
        } elseif (!$user['approved']) {
            error_log("Account not approved.");
        }
    }
}
require('head.php');
?>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mt-5">
                    <div class="card-body">
                        <h3 class="card-title text-center">Login</h3>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                            <a href="register.php" class="btn btn-link btn-block">Register</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require('bootstrap_script.php')?>
    
</body>
</html>

