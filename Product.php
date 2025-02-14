<?php
session_start();
include 'config/db.php'; // Ensure database connection

$user_logged_in = isset($_SESSION["user_id"]);
$profile_picture = ""; // Remove default pic handling

if ($user_logged_in) {
    $user_id = $_SESSION["user_id"]; 

    $query = "SELECT profile_picture FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($db_profile_picture);
        $stmt->fetch();
        $stmt->close();

        // Assign only if a valid path exists
        if (!empty($db_profile_picture)) {
            $profile_picture = $db_profile_picture;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="Website Icon" type="png" href="./images/w_logo.png"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="Product.css".css>
    <title>Irrigation hub</title>
</head>
<div class="images">
    <nav class="navbar navbar-expand-lg navbar-light " style="background-color:rgb(7, 105, 16);">
        <img class="navbar-brand" src="./images/logo.jpg" style="width:200px; height: 60px; border: radius 20px;">
        <button class="clr navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class=" brgclr navbar-toggler-icon" ></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <div  class="d-flex justify-content-center align-items-center" style="width: 70vw;">
                <div>
                    <ul class="navbar-nav mr-auto mt-2">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php" style="color: #FFFFFF; text-shadow: 0px 4px 4px rgba(0.4, 0.3, 0.5, 0.25);">Home </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="blog.php" style="color: #FFFFFF; text-shadow: 0px 4px 4px rgba(0.4, 0.3, 0.5, 0.25);">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Product.php" style="color: #FFFFFF; text-shadow: 0px 4px 4px rgba(0.4, 0.3, 0.5, 0.25);">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#contact" style="color: #FFFFFF; text-shadow: 0px 4px 4px rgba(0.4, 0.3, 0.5, 0.25);">Contact us</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php if ($user_logged_in && !empty($profile_picture)): ?>
                <a href="profile.php">
                <a href="profile.php">
                <img src="<?php echo htmlspecialchars($profile_picture); ?>"  alt="Profile" style="width: 50px; height: 50px;  border-radius: 50%; background-color: white; object-fit: cover; /* Ensures images scale properly */ border: 2px solid #ffffff;
                                                                                                   transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; margin-left: 240px; position: relative;">
                </a>
            <?php else: ?>
                <div class="form-inline login-btn">
                    <a class="nav-item text-center text-white" href="login.php">Log In</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>
        <div class="container" style="margin-top: 30px;">
            <h2>Soil moisture sensor</h2>
            
            <div class="container" style="margin-top:30px">
            <div class="row" style="row-gap: 10px;">
                <div class="col-md-3">
                <div class="grid-item text-center p-3" style="background-color: #D9D9D9;">
                    <img src="./images/item-1.jpg" alt="item" class="img-fluid p-3">
                    <a href="Product-1.html"><h6>V-Tech Soil Moisture Sensor</h6></a>
                    <p>Price: 12500</p>
                </div>
                </div>
                <div class="col-md-3">
                <div class="grid-item text-center p-3" style="background-color: #D9D9D9;">
                    <img src="./images/item-2.jpg" alt="item" class="img-fluid p-3">
                    <a href="Product-2.html">  <h6>Embsys Soil Moisture Sensor</h6></a>
                    <p>Price: 3000</p>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="container" style="margin-top: 30px;">
        <h2>Rain and snow sensor</h2>
        <div class="container" style="margin-top:30px">
            <div class="row" style="row-gap: 10px;">
            <div class="col-md-3">
            <div class="grid-item text-center p-3"style="background-color: #D9D9D9;">
                <img src="./images/item-3.jpg" alt="item" class="img-fluid p-3">
                <a href="Product-3.html"><h6>VT-SRS01 Snow & Rain Sensor, For Industrial</h6></a>
                <p>Price: 13500</p>
            </div>
            </div>
        </div>
        </div>
        </div>
        <div class="container" style="margin-top: 30px;">
        <h2>Wind speed  sensor</h2>
        <div class="container" style="margin-top:30px">
            <div class="row" style="row-gap: 10px;">
            <div class="col-md-3">
            <div class="grid-item text-center p-3"style="background-color: #D9D9D9;">
                <img src="./images/item-4.jpg" alt="item" class="img-fluid p-3"style="height: 170px;width:200px;">
                <a href="Product-4.html"><h6>Wind Speed And Direction Sensor</h6></a>
                <p>Price: 25000</p>

            </div>
            </div>
            <div class="col-md-3">
            <div class="grid-item text-center p-3"style="background-color: #D9D9D9;">
                <img src="./images/item-5.jpg" alt="item" class="img-fluid p-3">
                <a href="Product-5.html"><h6>Wind Speed Sensor, Anemometer</h6></a>
                <p>Price: 6900</p>
            </div>
            </div>
        </div>
        </div>  
    </div>
    <footer id="main-footer">
        <p>© 2023 Irrigation Hub. All rights reserved.</p>
    </footer>
</body>
</html>