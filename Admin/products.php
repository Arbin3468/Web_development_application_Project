<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
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
            <button class="btn btn-danger" id="logoutBtn">Logout</button>
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
                                data-description="<?= htmlspecialchars($row['description']) ?>">

                                Read More
                            </a>
                        </td>
                        <td>Rs. <?= number_format($row['price'], 2) ?></td>
                        <td>
                            <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($row['name']) ?>" width="80">
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm delete-btn" data-id="<?= $row['id'] ?>" data-name="<?= htmlspecialchars($row['name']) ?>">Delete</a>
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

    <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <span id="productName"></span>?
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger" id="confirmDelete">Yes, Delete</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
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
                    Are you sure you want to logout?
                </div>
                <div class="modal-footer">
                    <a href="logout.php" class="btn btn-danger">Yes, Logout</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".read-more").click(function (event) {
                event.preventDefault();
                var title = $(this).data("title");
                var description = $(this).data("description");

                $("#descModalLabel").text(title);
                $("#descModalBody").html(`
                    <p><strong>Description:</strong> ${description}</p>
                `);
                $("#descModal").modal("show");
            });

            $(".delete-btn").click(function (event) {
                event.preventDefault();
                var productId = $(this).data("id");
                var productName = $(this).data("name");

                $("#productName").text(productName);
                $("#deleteModal").modal("show");

                $("#confirmDelete").attr("href", "delete.php?id=" + productId);
            });

            $("#logoutBtn").click(function () {
                $("#logoutModal").modal("show");
            });
        });
    </script>
</body>
</html>
