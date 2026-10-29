<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYM - BMI Calculator</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Old+Standard+TT:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/Bmi2.css" />
    <script src="../assets/js/bmi.js" defer></script>
    <script>
        function Underweight() {
            window.open("https://static.onecms.io/wp-content/uploads/pdfs/sites/44/2023/05/10/7-day-healthy-weight-gain-letter-sized-final.pdf");
        }
        function Healthy() {
            window.open("https://files.verywellfit.com/meal-plans/1-Week-Healthy-and-Balanced-Meal-Plan.pdf");
        }
        function Overweight() {
            window.open("https://possible.in/wp-content/uploads/2018/05/Indian-Diet-Plan-for-5-1-1024x863.jpg");
        }
        function Obesity() {
            window.open("https://possible.in/wp-content/uploads/2018/05/Indian-Diet-Plan-for-5-1-1024x863.jpg");
        }
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">GYM System</a>
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
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img src="https://img.icons8.com/metro/26/000000/guest-male.png" alt="user">
                    <?php echo "Welcome " . htmlspecialchars($_SESSION['username']); ?>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <h1>BMI Calculator</h1>
    <label>
        <input id="h-input" type="number" placeholder="Enter Your Height in Centimeters">
    </label>
    <label>
        <input id="w-input" type="number" placeholder="Enter Your Weight in Kilograms">
    </label>
    <button type="button" onclick="Calculate()">Calculate BMI</button>

    <div class="bmi-value">
        <h4>BMI Value: </h4>
        <div id="bmi-output"></div>
    </div>
    <div class="status">
        <h4>Status: </h4>
        <div id="bmi-status"></div>
    </div>

    <button onclick="Underweight()">Underweight Diet Plan</button>
    <button onclick="Healthy()">Healthy Diet Plan</button>
    <button onclick="Overweight()">Overweight Diet Plan</button>
    <button onclick="Obesity()">Obesity Diet Plan</button>

    <h3 class="mt-3"><?php echo "Hello " . htmlspecialchars($_SESSION['username']); ?>! Check your BMI above.</h3>
    <hr>
    <div class="mt-3">
        <a href="addtocart.php">
            <button class="btn btn-primary btn-lg">Package Book Now</button>
        </a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
