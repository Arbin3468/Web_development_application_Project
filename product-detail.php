<?php
session_start();
include 'config/db.php'; // Database connection
include 'Admin/db.php'; // Database connection for admin side


// Check if 'id' is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid product ID.");
}

$product_id = intval($_GET['id']); // Get the product ID safely

// Fetch product details from the database
$query = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if product exists
if ($result->num_rows == 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - Irrigation Hub</title>
    <link rel="Website Icon" type="png" href="./images/w_logo.png">   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6">
            <img src="Admin/uploads/<?= htmlspecialchars($product['image']) ?>" class="img-fluid" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>
        
        <!-- Product Details -->
        <div class="col-md-6">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <p><strong>Price:</strong> Rs. <?= number_format($product['price'], 2) ?></p>
            <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($product['description'])) ?></p>
            <p><strong>Brand:</strong> <?= nl2br(htmlspecialchars($product['brand'])) ?></p>
            <p><strong>Type:</strong> <?= nl2br(htmlspecialchars($product['type'])) ?></p>
            <p><strong>Temperature_Range:</strong> <?= nl2br(htmlspecialchars($product['temperature_range'])) ?></p>
            <p><strong>Operating_Voltage:</strong> <?= nl2br(htmlspecialchars($product['operating_voltage'])) ?></p>
            <p><strong>Output_Voltage:</strong> <?= nl2br(htmlspecialchars($product['output_voltage'])) ?></p>
            <p><strong>Operating_current:</strong> <?= nl2br(htmlspecialchars($product['operating_current'])) ?></p>
            <p><strong>Interface:</strong> <?= nl2br(htmlspecialchars($product['interface'])) ?></p>
            <p><strong>Response_Time:</strong> <?= nl2br(htmlspecialchars($product['response_time'])) ?></p>
            <p><strong>Country_of_origin:</strong> <?= nl2br(htmlspecialchars($product['country_of_origin'])) ?></p>
            <p><strong>Mininum_Order_Quantity:</strong> <?= nl2br(htmlspecialchars($product['minimum_order_quantity'])) ?></p>
            <!-- Buy Now Button -->
            <form action="checkout.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']) ?>">
                <input type="hidden" name="product_price" value="<?= $product['price'] ?>">
                
                <a href="Product.php" class="btn btn-success btn-lg">Back</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
