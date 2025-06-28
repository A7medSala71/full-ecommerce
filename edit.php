<?php
// Start session
session_start();

// Check if user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != true) {
    echo "Access denied. Only admins can edit products.";
    exit;
}

// Check if the product ID is passed
if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ecomerce";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch product details by ID
    $sql = "SELECT * FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $productName = $product['name'];
        $productPrice = $product['price'];
        $productImage = $product['image'];
    } else {
        echo "Product not found.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateProduct'])) {
        // Handle form submission for updating the product
        $newName = $_POST['name'];
        $newPrice = $_POST['price'];

        // Handle image upload if a new file is provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $imageName = $_FILES['image']['name'];
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imageSize = $_FILES['image']['size'];
            $imageType = $_FILES['image']['type'];
            $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

            // Allowed image file extensions
            $allowedExt = array('jpg', 'jpeg', 'png', 'gif');

            if (in_array($imageExt, $allowedExt)) {
                $newImagePath = 'uploads/' . $imageName;

                // Move the uploaded file to the uploads directory
                if (move_uploaded_file($imageTmpName, $newImagePath)) {
                    $imagePathToSave = $newImagePath;
                } else {
                    echo "Error uploading the image.";
                    exit;
                }
            } else {
                echo "Invalid image format. Allowed formats: jpg, jpeg, png, gif.";
                exit;
            }
        } else {
            // If no new image is uploaded, retain the current image path
            $imagePathToSave = $productImage;
        }

        // Update the product in the database
        $updateSql = "UPDATE product SET name = ?, price = ?, image = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sdsi", $newName, $newPrice, $imagePathToSave, $productId);

        if ($updateStmt->execute()) {
            echo "Product updated successfully!";
        } else {
            echo "Error updating product: " . $conn->error;
        }
    }
    $conn->close();
} else {
    echo "Invalid or missing product ID.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product: <?php echo $productName; ?></h2>
    <form action="edit.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="productId" value="<?php echo $productId; ?>">
        
        <label for="name">Product Name:</label>
        <input type="text" name="name" value="<?php echo $productName; ?>"><br>

        <label for="price">Product Price:</label>
        <input type="text" name="price" value="<?php echo $productPrice; ?>"><br>

        <label for="image">Product Image:</label>
        <input type="file" name="image"><br>
        <p>Current Image:</p>
        <img src="<?php echo $productImage; ?>" alt="Product Image" width="100"><br>
        <div class="form-group">
            <button type="submit" name="updateProduct">Update Product</button>
            <a href="index.php" class="btn btn-secondary">Back to homepage</a>  <!-- Back button -->
        </div>
    </form>
</body>
</html>
