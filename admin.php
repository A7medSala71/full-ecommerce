<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "ecomerce";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['name']) && isset($_POST['price']) && isset($_FILES['image'])) {
        $ProductName = $_POST['name'];
        $ProductPrice = $_POST['price'];
        $ProductCategory = $_POST['category'];

        // Handle file upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $message = "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $message = "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $message = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            $message = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $message = "Sorry, your file was not uploaded.";
        } else {
            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $message = "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";

                // Insert data into the database
                $sql = "INSERT INTO product (name, price, image, category_id) VALUES ('$ProductName', '$ProductPrice', '$target_file', '$ProductCategory')";
                if ($conn->query($sql) === TRUE) {
                    $message .= " Product added successfully";
                } else {
                    $message .= " Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $message = "Form fields are not set.";
    }
}

// Fetch categories from the database
$categories = [];
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[$row["Id"]] = $row["name"];
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/admin.css" rel="stylesheet" />
    <title>Add Product and Contact Us Form</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
<div class="container">
    <div class="text">
        Add Product Form
    </div>
    <form action="admin.php" method="post" enctype="multipart/form-data">
        <div class="form-row">
            <div class="input-data">
                <input type="text" name="name" required>
                <div class="underline"></div>
                <label for="">Product Name</label>
            </div>
            <div class="input-data">
                <input type="text" name="price" required>
                <div class="underline"></div>
                <label for="">Price</label>
            </div>
        </div>
        <div class="form-row">
            <div class="input-data">
                <input type="file" name="image" accept="image/*" required>
                <div class="underline"></div>
            </div>
        </div>
        <div class="form-row">
            <div class="input-data">
                <select id="category" name="category" required>
                    <option value="" disabled selected>Select category</option>
                    <?php
                        foreach ($categories as $id => $name) {
                            echo "<option value='".$id."'>".$name."</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-row submit-btn">
            <div class="input-data">
                <div class="inner"></div>
                <input type="submit" value="Submit">
            </div>
        </div>
    </form>
</div>
</body>
</html>
