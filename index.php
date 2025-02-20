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
    <script src="https://kit.fontawesome.com/ecd1889ea0.js" crossorigin="anonymous"></script>   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="index.css">
    <title>Irrigation hub</title>
</head>
<body>       
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
                                <a class="nav-link" href="#contact" style="color: #FFFFFF; text-shadow: 0px 4px 4px rgba(0.4, 0.3, 0.5, 0.25);">Contact us</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php if ($user_logged_in && !empty($profile_picture)): ?>
                <a href="profile.php">
                <a href="profile.php">
                <img src="<?php echo htmlspecialchars($profile_picture); ?>" class="profile-pic" alt="Profile">
                </a>
            <?php else: ?>
                <div class="form-inline login-btn">
                    <a class="nav-item text-center text-white" href="login.php">Log In</a>
                </div>
            <?php endif; ?>
    </div>
        </nav>
        <div class="container center" >
            <div class="welcome text-center">
                <h1 class="mt-5"; text-transform: uppercase; style="font-weight: bolder;">Welcome to<br> <span style="color: #178B23;">Irrigation hub</span></h1>
                <div class="d-flex  justify-content-center mt-5">
                    <p class="welcome-text text-center">Are you tired of wasting water, time, and energy on maintaining your lawn or garden? Look no further! Our innovative smart irrigation products are here to revolutionize the way you water your plants.</p>
                </div>
        </div>
        </div>
    </div>
    <div style="overflow: hidden;">
        <div class="container">
            <div class="text-center mt-5">
                <h1 style="color:#178B23;">Overview</h1>
                <div class="row mt-5 overview-h" >
                    <div class="col-md-5 des-img">
                        <img src="./images/w_logo.png">
                    </div>
                <div class="col-md-7 ">
                    <div class="paragraph"style="font-size: 20px; width:90%;">
                        <p>Welcome to Irrigation Hub, where we specialize in providing an exceptional range of smart irrigation products to meet all your watering needs. Our commitment to innovation, efficiency, and sustainability ensures that you'll find the perfect solution for your lawn, garden, or landscape.</p>
                        <p>At Irrigation Hub, we take pride in our commitment to sustainability, convenience, and beautiful landscapes. 
                            Our smart irrigation products are trusted by homeowners, garden enthusiasts, and professionals alike.</p>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <h1 class="text-center" style="color: #178B23;"> Services</h1>
            <div class="row" style="row-gap: 20px;">
                <div class="col-md-6">
                    <div class="grid-item text-center p-3 shadow" style="background-color:#D9D9D9;">
                        <h3>Wide Range of smart irrigation products</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="grid-item  text-center p-3 shadow"style="background-color:#D9D9D9;">
                        <h3>compatibility and ease of<br> installation </h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="grid-item  text-center p-3 shadow"style="background-color:#D9D9D9;">
                        <h3>Smart Technology and <br> automation</h3>
                    </div>
                </div>
            <div class="col-md-6">
                <div class="grid-item text-center p-3 shadow"style="background-color:#D9D9D9;">
                    <h3>Energy efficency and <br>cost savings</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="map mt-5">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.2734175496644!2d85.32101877539138!3d27.70884317618165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1908ed7fbacd%3A0x49b04b284da7a96f!2sIIMS%20College!5e0!3m2!1sen!2snp!4v1685359044269!5m2!1sen!2snp" width="100%" height="300px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <section id="contact"></section>
    <div class="Contact mt-5">
        <div class="text-center">
            <h1 style="color: #178B23;">Contact Us</h1>
        </div>
        <div class="d-flex justify-content-center">
            <div class="row m-5 d-flex justify-content-center">
                <div class="col-md-3 mr-2">
                    <div class="ml-3 mb-4">
                        <i class="fa-sharp fa-solid fa-location-dot fa-2xl" style="color: #19bf0d;"></i>
                    </div>
                    <h4>Address</h4>
                    <p>Dobhidhara Marg<br>kathmandu 44600</p>
                </div>
                <div class="col-md-3 mr-2">
                    <div class="ml-3 mb-4">
                        <i class="fa-solid fa-phone fa-2xl" style="color: #19bf0d;"></i>
                    </div>
                    <h4>Phone Number</h4>
                    <p>9803522629</p>
                </div>
                <div class="col-md-3  ">
                    <div class="ml-3 mb-4">
                        <i class="fa-solid fa-message fa-2xl" style="color: #19bf0d;"></i>
                    </div>
                    <h4>Email</h4>
                    <p>smart@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
    <footer id="main-footer">
        <p>© 2025 Irrigation Hub. All rights reserved.</p>
    </footer>

</body>
</html>
