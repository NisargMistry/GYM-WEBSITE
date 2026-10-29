<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank.";
    } else {
        $sql  = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST['username']);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo "Something went wrong.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank.";
    } elseif (strlen(trim($_POST['password'])) < 5) {
        $password_err = "Password must be at least 5 characters.";
    } else {
        $password = trim($_POST['password']);
    }

    // Validate confirm password
    if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
        $confirm_password_err = "Passwords do not match.";
    }

    // Insert into database if no errors
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql  = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
                exit;
            } else {
                echo "Something went wrong, could not register.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GYM - Register</title>
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
    <h3>Please Register Here:</h3>
    <hr>
    <form action="" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Username</label>
                <input type="text" class="form-control <?= !empty($username_err) ? 'is-invalid' : '' ?>" name="username" placeholder="Username">
                <div class="invalid-feedback"><?= htmlspecialchars($username_err) ?></div>
            </div>
            <div class="form-group col-md-6">
                <label>Password</label>
                <input type="password" class="form-control <?= !empty($password_err) ? 'is-invalid' : '' ?>" name="password" placeholder="Min. 5 characters">
                <div class="invalid-feedback"><?= htmlspecialchars($password_err) ?></div>
            </div>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" class="form-control <?= !empty($confirm_password_err) ? 'is-invalid' : '' ?>" name="confirm_password" placeholder="Confirm Password">
            <div class="invalid-feedback"><?= htmlspecialchars($confirm_password_err) ?></div>
        </div>
        <div class="form-group">
            <label>Address</label>
            <input type="text" class="form-control" id="inputAddress" placeholder="Apartment, studio, or floor">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>City</label>
                <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="form-group col-md-4">
                <label>State</label>
                <select id="inputState" class="form-control">
                    <option value="">Choose...</option>
                    <option>Andhra Pradesh</option><option>Assam</option><option>Bihar</option>
                    <option>Chandigarh</option><option>Chhattisgarh</option><option>Delhi</option>
                    <option>Goa</option><option>Gujarat</option><option>Haryana</option>
                    <option>Himachal Pradesh</option><option>Jammu and Kashmir</option>
                    <option>Jharkhand</option><option>Karnataka</option><option>Kerala</option>
                    <option>Madhya Pradesh</option><option>Maharashtra</option><option>Manipur</option>
                    <option>Meghalaya</option><option>Mizoram</option><option>Nagaland</option>
                    <option>Odisha</option><option>Punjab</option><option>Rajasthan</option>
                    <option>Sikkim</option><option>Tamil Nadu</option><option>Telangana</option>
                    <option>Tripura</option><option>Uttar Pradesh</option><option>Uttarakhand</option>
                    <option>West Bengal</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label>Zip</label>
                <input type="text" class="form-control" id="inputZip">
            </div>
        </div>
        <div class="form-group form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck" required>
            <label class="form-check-label" for="gridCheck">I agree to the terms</label>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <p class="mt-3">Already have an account? <a href="login.php">Login here</a></p>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
