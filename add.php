<?php
session_start();
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true;

if (!$isAdmin) {
    die("Access denied. Only admins can add products.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecomerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $category_id = $_POST['category_id'];

    // Upload the image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    // Insert into the database
    $sql = "INSERT INTO product (name, price, image, category_id) VALUES ('$name', '$price', '$target_file', '$category_id')";
    if ($conn->query($sql) === TRUE) {
        echo "New product added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
</head>
<body>
    <h2>Add New Product</h2>
    <form action="add.php" method="POST" enctype="multipart/form-data">
        <label for="name">Product Name:</label><br>
        <input type="text" name="name" required><br>

        <label for="price">Price:</label><br>
        <input type="text" name="price" required><br>

        <label for="image">Product Image:</label><br>
        <input type="file" name="image" required><br>

        <label for="category_id">Category:</label><br>
        <select name="category_id" required>
            <option value="1">Toys</option>
            <option value="2">Furniture</option>
            <option value="3">Camp</option>
        </select><br><br>

        <div class="form-group">
            <input type="submit" value="Add Product">
            <a href="index.php" class="btn btn-secondary">Back to homepage</a>  <!-- Back button -->
        </div>
    </form>
</body>
</html>
