<?php
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
        <table class="table table-bordered table-striped">
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
                            <?php 
                            $desc = strip_tags(htmlspecialchars_decode($row['description'])); // Remove HTML tags
                            if (strlen($desc) > 100) {
                                echo substr($desc, 0, 100) . '... <a href="#" class="text-primary read-more" data-id="' . $row['id'] . '" data-description="' . htmlspecialchars($row['description']) . '" data-title="' . htmlspecialchars($row['name']) . '">Read More</a>';
                            } else {
                                echo $desc;
                            }
                            ?>
                        </td>
                        <td>Rs. <?= number_format($row['price'], 2) ?></td>
                        <td>
                            <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="product-image" alt="<?= htmlspecialchars($row['name']) ?>" width="80">
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

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".read-more").click(function (event) {
                event.preventDefault();
                var title = $(this).data("title");
                var description = $(this).data("description");

                $("#descModalLabel").text(title);
                $("#descModalBody").html(description);
                $("#descModal").modal("show");
            });
        });
    </script>
</body>
</html>
