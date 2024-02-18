<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Bmi2.css">
    <script src="bmi.js" defer></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Old+Standard+TT:wght@700&display=swap" rel="stylesheet">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <link rel="stylesheet" href="Bmi2.css" />
 <script>
    function Underweight() {
        window.open("https://static.onecms.io/wp-content/uploads/pdfs/sites/44/2023/05/10/7-day-healthy-weight-gain-letter-sized-final.pdf")
      }
      function Healthy() {
        window.open("https://files.verywellfit.com/meal-plans/1-Week-Healthy-and-Balanced-Meal-Plan.pdf")
      }
      function Overweight() {
        window.open("https://possible.in/wp-content/uploads/2018/05/Indian-Diet-Plan-for-5-1-1024x863.jpg")
      }
      function Obesity() {
        window.open("https://possible.in/wp-content/uploads/2018/05/Indian-Diet-Plan-for-5-1-1024x863.jpg")
      }
  </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#"> GMY Login System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="register.php">Register</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>

      
     
    </ul>

  <div class="navbar-collapse collapse">
  <ul class="navbar-nav ml-auto">
  <li class="nav-item active">
        <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png"> <?php echo "Welcome ". $_SESSION['username']?></a>
      </li>
  </ul>
  </div>


  </div>
</nav>


    <div class="container">  
        <h1>BMI Calculator</h1>
        <label>
            <input id="h-input" type="number" placeholder="Enter Your Height in Centimeters: ">
        </label>        
        <label>
            <input id="w-input" type="number" placeholder="Enter Your Weight in Kilogrames: ">
        </label>            
        <button type="submit" onclick="Calculate()">Calculate BMI</button>
            
        <div class="bmi-value">
            <h4>BMI Value: </h4>
            <div id="bmi-output"></div>
        </div>
        <div class="status">
            <h4>Status: </h4>
            <div id="bmi-status"></div>
        </div>
        <button onclick="Underweight()">Underweight</button>
        <button onclick="Healthy()">Healthy</button>
        <button onclick="Overweight()">Overweight</button>
        <button onclick="Obesity()">Obesity</button>
        <h3><?php echo "your bmi ". $_SESSION['username']?>! You can now go to main page</h3>
<hr> 

<div>
  <h4> 
  <a href='addtocart.php'> 
        <button class="btn btn-primary btn-lg "> 
            Package Book Now
        </button> 
    </a>
    </h4>
</div> 

    </div>
   

</body>
</html>