<?php
session_start();
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true;

if (!$isAdmin) {
    die("Access denied. Only admins can delete products.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecomerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['productId'])) {
    $product_id = $_POST['productId'];

    // Delete the product
    $sql = "DELETE FROM product WHERE id='$product_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
</head>

<body>
<div class="form-group">
    <a href="index.php" class="btn btn-secondary">Back to homepage</a>  <!-- Back button -->
</div>
</body>