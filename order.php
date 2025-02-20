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
    <style>
        body {
            background-color: #f5f5f5;
        }
        /* .space {
            margin: 0 4%;
        } */
        li a {
            width: 10vw;
            font-size: 20px;
            font-weight: bolder;
        }
        .clr{
            background-color:#0082CE;
            color: #D9D9D9;
        }
        a:hover {
            color: #ffffff;
        }
        .login-btn a {
            text-decoration: none;
            width: 5vw;
            font-size: 20px;
            font-weight: bold;
            border-radius: 15px;
            background-color: #176ea0;
        }
        .container h2 {
            font-style: normal;
            font-size: 50px;
            line-height: 61px;
            color: #432f24;
        }
        #main {
            float: left;
            width: 24%;
            padding: 0 30px;
            box-sizing: border-box;
            background-color: #ffffff;
            font-style: normal;
            align-items: center;
            color: #432f24;
        }
        #sidebar {
            float: right;
            width: 70%;
            padding: 10px;
            color: #432f24;
            font-style: normal;
            box-sizing: border-box;
        }
        .search-button {
            background-color: #17458b;
            color: #ffffff;
            padding: 10px 20px;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .search-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }
        .dai {
            background-color: #ffffff;
            color: #432f24;
            font-style: normal;
            font-weight: 600;
            font-size: 15px;
            line-height: 18px;
            float: right;
            width: 70%;
            box-sizing: border-box;
            min-height: 35vh;
            
        }
        @media(max-width: 600px) {
            #main {
                width: 100%;
                float: none;
            }
            #sidebar {
                width: 100%;
                float: none;
            } 
        }
    </style>
    <title>Irrigation Hub</title>
</head>
<body>
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
    <div class="container mt-5">
        <a href="Product.php"><button class="mb-2 mt-3" style="border: none;"><i class="fa-sharp fa-solid fa-arrow-left"></i></button></a>
        <h2 class="text-center">Order history</h2>
        <div class="row">
            <div id="main" class="col-md-3">
                <div class="p-3">
                    <h6>Dashboard</h6>
                    <a href="#">
                        <h6 style="color: #17458b;">- Order History</h6>
                    </a>
                    <a href="your_cart.php">
                        <h6 style="color: #432f24;">- Your Cart</h6>
                    </a>
                </div>
            </div>
            <div id="sidebar" class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <form action="#" method="post">
                            <div>
                                <label style="font-weight: 600; font-size: 15px; line-height: 18px; color: #432f24;">Order ID</label>
                                <input type="text" name="OrderId" placeholder="Enter your Order ID" style="border: 1px solid #ddd; padding: 5px; font-size: 14px;">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <label style="font-weight: 600; font-size: 15px; line-height: 18px; color: #432f24;">From</label>
                            <input type="date">
                        </div>
                        <div>
                            <label style="font-weight: 600; font-size: 15px; line-height: 18px; color: #432f24; margin-left: 18px;">To</label>
                            <input type="date">
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: center; margin-right: 200px;">
                    <button type="submit" class="search-button mt-3">Search</button>
                </div>
            </div>
        </div>
    </div>
    <div class="dai mt-5 mr-5">
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</body>
</html>