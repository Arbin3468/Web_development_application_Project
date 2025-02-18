<?php
include 'db.php';
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invalid Product ID.");
}

// Fetch product details
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$product) {
    die("Product not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $temperature_range = $_POST['temperature_range'];
    $operating_voltage = $_POST['operating_voltage'];
    $output_voltage = $_POST['output_voltage'];
    $operating_current = $_POST['operating_current'];
    $interface = $_POST['interface'];
    $response_time = $_POST['response_time'];
    $country_of_origin = $_POST['country_of_origin'];
    $minimum_order_quantity = $_POST['minimum_order_quantity'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $imageName = basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . time() . "_" . $imageName; // Unique filename
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Allow only specific formats
        $allowedTypes = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedTypes)) {
            echo "Only JPG, JPEG, PNG & GIF files are allowed.";
            exit;
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
        } else {
            echo "Error uploading image.";
            exit;
        }
    } else {
        $imagePath = $product['image']; // Keep old image if not changed
    }

    // Update product with prepared statement
    $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, brand=?, type=?, temperature_range=?, operating_voltage=?, output_voltage=?, operating_current=?, interface=?, response_time=?, country_of_origin=?, minimum_order_quantity=?, image=? WHERE id=?");
    $stmt->bind_param("ssdsssssssssssi", $name, $description, $price, $brand, $type, $temperature_range, $operating_voltage, $output_voltage, $operating_current, $interface, $response_time, $country_of_origin, $minimum_order_quantity, $imagePath, $id);
    
    if ($stmt->execute()) {
        header("Location: products.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Edit Product</h2>
    <form method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow">
        <div class="form-group">
            <label><strong>Name:</strong></label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label><strong>Description:</strong></label>
            <textarea name="description" class="form-control" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <div class="form-group">
            <label><strong>Price:</strong></label>
            <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label><strong>Brand:</strong></label>
            <input type="text" name="brand" value="<?= htmlspecialchars($product['brand']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><strong>Type:</strong></label>
            <input type="text" name="type" value="<?= htmlspecialchars($product['type']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><strong>Temperature Range:</strong></label>
            <input type="text" name="temperature_range" value="<?= htmlspecialchars($product['temperature_range']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><strong>Operating Voltage:</strong></label>
            <input type="text" name="operating_voltage" value="<?= htmlspecialchars($product['operating_voltage']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><strong>Output Voltage:</strong></label>
            <input type="text" name="output_voltage" value="<?= htmlspecialchars($product['output_voltage']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><strong>Operating Current:</strong></label>
            <input type="text" name="operating_current" value="<?= htmlspecialchars($product['operating_current']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><strong>Interface:</strong></label>
            <input type="text" name="interface" value="<?= htmlspecialchars($product['interface']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><strong>Response Time:</strong></label>
            <input type="text" name="response_time" value="<?= htmlspecialchars($product['response_time']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><strong>Country of Origin:</strong></label>
            <input type="text" name="country_of_origin" value="<?= htmlspecialchars($product['country_of_origin']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><strong>Minimum Order Quantity:</strong></label>
            <input type="number" name="minimum_order_quantity" value="<?= htmlspecialchars($product['minimum_order_quantity']) ?>" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update Product</button>
        <a href="products.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
