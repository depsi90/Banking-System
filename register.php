<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $role]);

    echo "Registration successful. Waiting for admin approval.";
}

require('head.php');
?>


<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mt-5">
                    <div class="card-body">
                        <h3 class="card-title text-center">Register</h3>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                           <div class="form-group">
                           <select name="role" class="form-control" >
        <option value="customer">Customer</option>
    </select>
                           </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                            <a href="index.php" class="btn btn-link btn-block">Login</a>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require('bootstrap_script.php')?>
    
</body>
</html>