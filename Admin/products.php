<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Continue with the rest of your code for managing products
include 'db.php';
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="products.css"> <!-- Custom CSS -->
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Product List</h2>
        <div class="text-right mb-3">
            <a href="add.php" class="btn btn-primary">Add New Product</a>
        </div>
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr class="bg-dark text-white">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>
                            <?= strip_tags(htmlspecialchars_decode($row['description'])) ?>
                            <br>
                            <a href="#" class="text-primary read-more" 
                                data-id="<?= $row['id'] ?>" 
                                data-title="<?= htmlspecialchars($row['name']) ?>" 
                                data-description="<?= htmlspecialchars($row['description']) ?>"
                                data-brand="<?= htmlspecialchars($row['brand']) ?>"
                                data-type="<?= htmlspecialchars($row['type']) ?>"
                                data-temperature_range="<?= htmlspecialchars($row['temperature_range']) ?>"
                                data-operating_voltage="<?= htmlspecialchars($row['operating_voltage']) ?>"
                                data-output_voltage="<?= htmlspecialchars($row['output_voltage']) ?>"
                                data-operating_current="<?= htmlspecialchars($row['operating_current']) ?>"
                                data-interface="<?= htmlspecialchars($row['interface']) ?>"
                                data-response_time="<?= htmlspecialchars($row['response_time']) ?>"
                                data-country_of_origin="<?= htmlspecialchars($row['country_of_origin']) ?>"
                                data-minimum_order_quantity="<?= htmlspecialchars($row['minimum_order_quantity']) ?>">
                                Read More
                            </a>
                        </td>
                        <td>Rs. <?= number_format($row['price'], 2) ?></td>
                        <td>
                            <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($row['name']) ?>" width="80">
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for Full Description -->
    <div class="modal fade" id="descModal" tabindex="-1" role="dialog" aria-labelledby="descModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="descModalBody"></div>
            </div>
        </div>
    </div>
    <!-- Logout Form -->
    <form action="login.php" method="POST" class="mt-4">
            <button type="submit" name="logout" class="btn btn-secondary">Logout</button>
        </form>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".read-more").click(function (event) {
                event.preventDefault();
                var title = $(this).data("title");
                var description = $(this).data("description");
                var brand = $(this).data("brand");
                var type = $(this).data("type");
                var temperature_range = $(this).data("temperature_range");
                var operating_voltage = $(this).data("operating_voltage");
                var output_voltage = $(this).data("output_voltage");
                var operating_current = $(this).data("operating_current");
                var interface = $(this).data("interface");
                var response_time = $(this).data("response_time");
                var country_of_origin = $(this).data("country_of_origin");
                var minimum_order_quantity = $(this).data("minimum_order_quantity");

                $("#descModalLabel").text(title);
                $("#descModalBody").html(` 
                    <p><strong>Description:</strong> ${description}</p>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Brand:</strong> ${brand}</p>
                            <p><strong>Type:</strong> ${type}</p>
                            <p><strong>Temperature Range:</strong> ${temperature_range}</p>
                            <p><strong>Operating Voltage:</strong> ${operating_voltage}</p>
                            <p><strong>Output Voltage:</strong> ${output_voltage}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Operating Current:</strong> ${operating_current}</p>
                            <p><strong>Interface:</strong> ${interface}</p>
                            <p><strong>Response Time:</strong> ${response_time}</p>
                            <p><strong>Country of Origin:</strong> ${country_of_origin}</p>
                            <p><strong>Minimum Order Quantity:</strong> ${minimum_order_quantity}</p>
                        </div>
                    </div>
                `);
                $("#descModal").modal("show");
            });
        });
    </script>
</body>
</html>
