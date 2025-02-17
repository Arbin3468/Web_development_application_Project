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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300&family=Kadwa:wght@400;700&family=Lato:wght@300&family=Tsukimi+Rounded:wght@500&display=swap');
    
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
        }
        li a{
            width:100%;
            font-size: 20px;
            font-weight: bolder;
            line-height: 60%;
            margin-right: 20px;
        }

        a:hover {
            color: #ffffff;
        }

        .login-btn a{
            text-decoration: none;
            width:8vw;
            font-weight: bold;
            font-size: 20px;
            border-radius: 10px;
            background-color:#183647;
            margin-left: 60px;
            position: absolute;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
}
        .clr{
            background-color:#0082CE;
            color: #D9D9D9;
        }
        @media(max-width:600px){
        .login-btn a{
            width: 20vw;
            }
        }
.images{
    background-image: url(./images/Blog.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center center;
    height: 100vh;
    background-position: 80%;
    overflow: hidden;
}
.welcome{
    padding-top: 12px;
    text-align: center;
    letter-spacing: 2%;
    margin-top: 15vh;
    width: 50%;
    height: 45vh;
    background-color:rgba(182, 223, 186,.60);
    border-radius: 10px;
}
.welcome h3 {
    margin-top: 30px;
    margin-left: -300px;
    font-weight: bold;
    letter-spacing: 5%;
    width: 60vw;
    height: 10vh;
    font-size: 200%;
        }
.welcome p {
        
            margin-top: 5px;
            font-style: normal;
            font-weight: 500;
            font-size: 1 vw;
            height: 40px;
            letter-spacing: 0.05em;
            color: #432F24;
        }
        .showcase {
            margin: auto;
            overflow: hidden;
            width: 90%;
        }

        #main {
            float: left;
            width: 45%;
            box-sizing: border-box;
            margin-top: 40px;
        }

        #sidebar {
            float: right;
            width: 45%;
            box-sizing: border-box;
            text-align: center;
            margin-top: 40px;
        }

        #main2 {
            float: left;
            width: 45%;
            box-sizing: border-box;
            margin-top: 40px;
        }

        #sidebar2 {
            float: right;
            width: 45%;
            box-sizing: border-box;
            text-align: center;
            margin-top: 40px;
        }
        #sidebar p {
            font-style: normal;
            font-weight: 500;
            font-size: 1.6em;
            line-height: 45px;
            letter-spacing: 0em;
            color: #432F24;
        }
        #main2 p {
            font-style: normal;
            font-weight: 500;
            font-size: 1.6em;
            line-height: 45px;
            letter-spacing: 0em;
            color: #432F24;
        }

        #main-footer {
            margin-top: 40px;
            background: #333;
            color: #f4f4f4;
            text-align: center;
            padding: 40px;
            font-family: 'Inter';
            font-style: normal;
            font-weight: 700;
            font-size: 25px;
        }
.col-md-6 p{
    font-style: normal;
font-weight: 600;
font-size: 1em;
line-height: 35px;
text-align: center;
letter-spacing: 0.1em;
color: #432F24;
}
        @media (max-width: 600px) {
            #main,
            #main2 {
                width: 100%;
                float: none;
            }

            #sidebar,
            #sidebar2 {
                width: 100%;
                float: none;
            }

            .showcase:nth-child(2) #main2 {
                order: -1;
                margin-bottom: 40px;
            }

            .showcase:nth-child(2) #sidebar2 {
                order: -2;
                margin-bottom: 40px;
            }

    @media screen and (max-width: 768px) {
    .welcome {
    width: 90%;
    margin-top: 15vh;
    }
    }

@media screen and (max-width: 480px) {
    .welcome {
    width: 100%;
    margin-top: 15vh;
    }

    .welcome h3 {
    font-size: 6vw;
    }

    .welcome p {
    font-size: 3.5vw;
    }    
    }
    @media(max-width:600px){
    .login-btn a{
        width: 20vw;
    }
    }

       }
    </style>
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
    
        <div class="container">
        <div class="welcome text-align:center">
            <h3>Smart Irrigation System</h3>
            <p class="font-weight-bold">Smart irrigation systems are a combination of advanced technology of sprinklers with nozzles that improve coverage and watering irrigation controllers and water conservation systems that monitor moisture-related conditions on your property and automatically adjust watering to optimal levels.</p>
    </div>
    </div>
    </div>
    <div class="showcase">
        <section id="main">
            <a href="./images/Blog-1.jpg"><img src="./images/Blog-1.jpg" alt="blog" image width="100%"></a>
        </section>
        <aside id="sidebar">
            <p>Agriculture is vital for the economy, and meeting the increasing food demands and adapting to consumer preferences is challenging. Technological advancements like smart irrigation offer a promising solution. By using data-intensive methods, smart irrigation maximizes productivity while minimizing environmental impact. Modern agriculture generates valuable data from sensors, enabling better decision-making, resource optimization, and achieving sector objectives efficiently.</p>
        </aside>
    </div>
    <div class="showcase">
        <aside id="sidebar2">
            <a href="./images/Blog-2.jpg"><img src="./images/Blog-2.jpg" alt="blog" image width="100%"></a>
        </aside>
        <section id="main2">
            <p>Creating a beautiful, lush landscape is a dream for many homeowners and garden enthusiasts. However, achieving that vibrant greenery often comes at a cost—water consumption. Traditional irrigation methods can be inefficient, resulting in water waste and higher utility bills.</p>
            <p>Fortunately, smart irrigation systems have emerged as a revolutionary solution that not only promotes sustainability but also enhances the health and beauty of your landscape. In this article, we'll explore the numerous benefits of smart irrigation and how it can transform your outdoor space.</p>
        </section>
    </div>
    <div class="container mt-5">
        <h1 class="text-center mb-4" style="color: #178B23;">Advantages of Smart Irrigation</h1>
        <div class="row" style="row-gap: 20px;">
            <div class="col-md-6">
                <div class="grid-item text-center p-3 shadow" style="background-color:#D9D9D9;">
                    <p>Water Conservation:<br> Smart irrigation systems saves water by delivering precise amounts of water based on real-time data.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="grid-item  text-center p-3 shadow"style="background-color:#D9D9D9;">
                    <p>Cost Savings:<br>By optimizing water usage, smart irrigation helps reduce water bills and associated energy costs.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="grid-item  text-center p-3 shadow"style="background-color:#D9D9D9;">
                    <p>Improved Plant Health:<br>Smart irrigation ensures plants receive the right amount of water at the right time, promoting healthier growth and higher crop yields.</p>
                </div>
            </div>
        <div class="col-md-6">
            <div class="grid-item text-center p-3 shadow"style="background-color:#D9D9D9;">
                <p>Time Efficiency:<br>Automated scheduling and remote control features save farmers time and effort in managing irrigation operations.</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="grid-item  text-center p-3 shadow"style="background-color:#D9D9D9;">
                <p>Environmental Sustainability:<br>Smart irrigation reduces water runoff, soil erosion, and over-extraction, contributing to sustainable farming practices.</p>
            </div>
        </div>
    <div class="col-md-6">
        <div class="grid-item text-center p-3 shadow"style="background-color:#D9D9D9;">
            <p>Customization and Flexibility:<br>Smart irrigation systems can be tailored to specific crops, soil types, and weather conditions for optimal irrigation strategies.</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="grid-item  text-center p-3 shadow"style="background-color:#D9D9D9;">
            <p>Data-Driven Insights:<br>By analyzing data on soil moisture and weather patterns, smart irrigation provides valuable insights for informed decision-making.</p>
        </div>
    </div>
<div class="col-md-6">
    <div class="grid-item text-center p-3 shadow"style="background-color:#D9D9D9;">
        <p>Integration with IoT and Automation:<br> Smart irrigation can be seamlessly integrated with IoT platforms for enhanced control and coordination in farm management.</p>
    </div>
</div>
    </div>
</div>
    <footer id="main-footer">
        <p>© 2023 Irrigation Hub. All rights reserved.</p>
    </footer>
</body>
</html>