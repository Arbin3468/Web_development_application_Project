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

// Update user details (for firstname, lastname, phone, email individually)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_firstname'])) {
        $firstname = trim($_POST['firstname']);
        $sql = "UPDATE users SET firstname = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $firstname, $user_id);
        if ($stmt->execute()) {
            echo "First name updated successfully!";
        } else {
            echo "Error updating first name: " . $stmt->error;
        }
    }

    if (isset($_POST['update_lastname'])) {
        $lastname = trim($_POST['lastname']);
        $sql = "UPDATE users SET lastname = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $lastname, $user_id);
        if ($stmt->execute()) {
            echo "Last name updated successfully!";
        } else {
            echo "Error updating last name: " . $stmt->error;
        }
    }

    if (isset($_POST['update_phone'])) {
        $phone = trim($_POST['phone']);
        $sql = "UPDATE users SET phone = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $phone, $user_id);
        if ($stmt->execute()) {
            echo "Phone number updated successfully!";
        } else {
            echo "Error updating phone number: " . $stmt->error;
        }
    }

    if (isset($_POST['update_email'])) {
        $email = trim($_POST['email']);
        $sql = "UPDATE users SET email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $email, $user_id);
        if ($stmt->execute()) {
            echo "Email updated successfully!";
        } else {
            echo "Error updating email: " . $stmt->error;
        }
    }
}

// Handle profile picture upload (if a new file is selected)
if (isset($_POST['update_picture'])) {
    $profilePicTmp = $_FILES["profile_picture"]["tmp_name"];
    
    if (!empty($profilePicTmp)) {
        $profilePicName = $_FILES["profile_picture"]["name"];
        $uploadDir = "uploads/";
        $profilePicPath = $uploadDir . basename($profilePicName);

        // Validate file type
        $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
        $fileType = mime_content_type($profilePicTmp);

        if (!in_array($fileType, $allowedTypes)) {
            die("Error: Invalid file type! Please upload JPG, PNG, or GIF.");
        }

        if (move_uploaded_file($profilePicTmp, $profilePicPath)) {
            // Update the user's profile picture in the database
            $sql = "UPDATE users SET profile_picture = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $profilePicPath, $user_id);
            if ($stmt->execute()) {
                echo "Profile picture updated successfully!";
            } else {
                echo "Error updating profile picture: " . $stmt->error;
            }
        } else {
            die("Error: Failed to upload image.");
        }
    }
}

// Handle user deletion
if (isset($_POST['delete_account'])) {
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        session_destroy();
        header("Location: login.php");
        exit();
    } else {
        echo "Error deleting account: " . $stmt->error;
    }
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>    
    <script src="https://kit.fontawesome.com/ecd1889ea0.js" crossorigin="anonymous"></script>   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="index.css">
    <title>Irrigation hub</title>
</head>
<body>
    
    <div class="container mt-5">
        <h2 class="text-center">Edit Profile</h2>

        <!-- Form for updating first name -->
        <form action="profileedits.php" method="POST">
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
            </div>
            <button type="submit" name="update_firstname" class="btn btn-primary">Update First Name</button>
        </form>

        <!-- Form for updating last name -->
        <form action="profileedits.php" method="POST" class="mt-4">
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
            </div>
            <button type="submit" name="update_lastname" class="btn btn-primary">Update Last Name</button>
        </form>

        <!-- Form for updating phone -->
        <form action="profileedits.php" method="POST" class="mt-4">
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>
            <button type="submit" name="update_phone" class="btn btn-primary">Update Phone</button>
        </form>

        <!-- Form for updating email -->
        <form action="profileedits.php" method="POST" class="mt-4">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <button type="submit" name="update_email" class="btn btn-primary">Update Email</button>
        </form>

        <!-- Form for updating profile picture -->
        <form action="profileedits.php" method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="form-group">
                <label for="profile_picture">Profile Picture:</label>
                <input type="file" name="profile_picture" id="profile_picture" class="form-control">
                <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="mt-3" width="100">
            </div>
            <button type="submit" name="update_picture" class="btn btn-primary">Update Profile Picture</button>
        </form>

        <!-- Form for deleting account -->
        <form action="profileedits.php" method="POST" class="mt-4">
            <button type="submit" name="delete_account" class="btn btn-danger">Delete Account</button>
        </form>

        <form action="profile.php" method="POST" class="mt-4">
            <button name="profile" class="btn btn-secondary">Profile</button>
        </form>

        <!-- Form for logout -->
        <form action="profile.php" method="POST" class="mt-4">
            <button type="submit" name="logout" class="btn btn-secondary">Logout</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
