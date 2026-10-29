<?php
// Handle login
session_start();

// Redirect if already logged in
if (isset($_SESSION['username'])) {
    header("location: welcome.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        $err = "Please enter username and password.";
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }

    if (empty($err)) {
        $sql  = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        $_SESSION["username"] = $username;
                        $_SESSION["id"]       = $id;
                        $_SESSION["loggedin"] = true;
                        header("location: welcome.php");
                        exit;
                    } else {
                        $err = "Invalid username or password.";
                    }
                }
            } else {
                $err = "Invalid username or password.";
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GYM - Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/register.css" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">GYM Login System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="../index.html">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <h3>Please Login Here:</h3>
    <hr>
    <?php if (!empty($err)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>
    <form action="" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="agreeCheck" required>
            <label class="form-check-label" for="agreeCheck">I agree to the terms</label>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </form>
    <p class="mt-3">Don't have an account? <a href="register.php">Register here</a></p>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
