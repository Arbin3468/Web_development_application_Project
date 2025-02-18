<?php
session_start();
include 'config/db.php'; // Include database connection

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get user ID from session

// Fetch the user's data from the database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="Website Icon" type="png" href="./images/w_logo.png"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>    
    <script src="https://kit.fontawesome.com/ecd1889ea0.js" crossorigin="anonymous"></script>   
    <link rel="stylesheet" href="index.css">
    <title>Irrigation Hub - User Profile</title>
</head>
<body>

    <div class="container mt-5">
        <h2 class="text-center">User Profile</h2>

        <div class="form-group">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" class="form-control" value="<?php echo $user['firstname']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" class="form-control" value="<?php echo $user['lastname']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" class="form-control" value="<?php echo $user['phone']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" class="form-control" value="<?php echo $user['email']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="profile_picture">Profile Picture:</label>
            <br>
            <img src="<?php echo $user['profile_picture']; ?>" alt="Profile Picture" class="mt-3" width="100">
        </div>

        <a href="profileedits.php" class="btn btn-success btn-lg">Profile Settings</a>

        <!-- Logout Button -->
        <button type="button" class="btn btn-secondary mt-4" data-toggle="modal" data-target="#logoutModal">
            Logout
        </button>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <form action="logout.php" method="POST">
                        <button type="submit" name="logout" class="btn btn-danger">Yes, Logout</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
