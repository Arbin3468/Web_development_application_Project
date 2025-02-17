<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Specifications
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $temperature = $_POST['temperature'];
    $operating_voltage = $_POST['operating_voltage'];
    $output_voltage = $_POST['output_voltage'];
    $operating_current = $_POST['operating_current'];
    $interface = $_POST['interface'];
    $response_time = $_POST['response_time'];
    $country = $_POST['country'];
    $min_order = $_POST['min_order'];

    // Format description with specifications as HTML
    $full_description = "
        <h6>Product Description</h6>
        <p>$description</p>
        <h6>Product Specification</h6>
        <table border='1'>
            <tr><th>Brand</th><td>$brand</td></tr>
            <tr><th>Type</th><td>$type</td></tr>
            <tr><th>Temperature Range</th><td>$temperature</td></tr>
            <tr><th>Operating Voltage</th><td>$operating_voltage</td></tr>
            <tr><th>Output Voltage</th><td>$output_voltage</td></tr>
            <tr><th>Operating Current</th><td>$operating_current</td></tr>
            <tr><th>Interface</th><td>$interface</td></tr>
            <tr><th>Response Time</th><td>$response_time</td></tr>
            <tr><th>Country of Origin</th><td>$country</td></tr>
            <tr><th>Minimum Order Quantity</th><td>$min_order</td></tr>
        </table>
    ";

    // Handle Image Upload
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Save product in database
        $full_description = mysqli_real_escape_string($conn, $full_description);
        $sql = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$full_description', '$price', '$image')";
        if ($conn->query($sql) === TRUE) {
            header("Location: products.php");
            exit();
        } else {
            echo "Database Error: " . $conn->error;
        }
    } else {
        echo "Image upload failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h2 {
            color: #007bff;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            color: #495057;
        }
        .btn {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            padding: 10px 20px;
            width: 100%;
        }
        .btn:hover {
            background-color: #218838;
        }
        .form-control, .form-control-file {
            border-radius: 5px;
        }
        h5 {
            color: #343a40;
            margin-top: 20px;
            font-size: 1.2em;
        }
        .table {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .table th, .table td {
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Product Description:</label>
            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
        </div>

        <h5>Product Specifications</h5>

        <div class="form-group">
            <label for="brand">Brand:</label>
            <input type="text" class="form-control" id="brand" name="brand" required>
        </div>

        <div class="form-group">
            <label for="type">Type:</label>
            <input type="text" class="form-control" id="type" name="type" required>
        </div>

        <div class="form-group">
            <label for="temperature">Temperature Range:</label>
            <input type="text" class="form-control" id="temperature" name="temperature" required>
        </div>

        <div class="form-group">
            <label for="operating_voltage">Operating Voltage:</label>
            <input type="text" class="form-control" id="operating_voltage" name="operating_voltage" required>
        </div>

        <div class="form-group">
            <label for="output_voltage">Output Voltage:</label>
            <input type="text" class="form-control" id="output_voltage" name="output_voltage" required>
        </div>

        <div class="form-group">
            <label for="operating_current">Operating Current:</label>
            <input type="text" class="form-control" id="operating_current" name="operating_current" required>
        </div>

        <div class="form-group">
            <label for="interface">Interface:</label>
            <input type="text" class="form-control" id="interface" name="interface" required>
        </div>

        <div class="form-group">
            <label for="response_time">Response Time:</label>
            <input type="text" class="form-control" id="response_time" name="response_time" required>
        </div>

        <div class="form-group">
            <label for="country">Country of Origin:</label>
            <input type="text" class="form-control" id="country" name="country" required>
        </div>

        <div class="form-group">
            <label for="min_order">Minimum Order Quantity:</label>
            <input type="text" class="form-control" id="min_order" name="min_order" required>
        </div>

        <div class="form-group">
            <label for="image">Product Image:</label>
            <input type="file" class="form-control-file" id="image" name="image" required>
        </div>

        <button type="submit" class="btn btn-success btn-block">Add Product</button>
    </form>
</div>

</body>
</html>
