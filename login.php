<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecomerce";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!empty($username) && !empty($password)) {
            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['id']; // Assuming 'id' is the primary key of the 'users' table
                    $_SESSION['username'] = $username;
                    $_SESSION['loggedin'] = true; // Set login status

                    // Check if the user is admin
                    if ($username === 'admin') {
                        $_SESSION['is_admin'] = true; // Set admin session
                    } else {
                        $_SESSION['is_admin'] = false; // Normal user
                    }

                    header("Location: index.php"); // Redirect to index page
                    exit();
                } else {
                    $message = "Invalid username or password.";
                }
            } else {
                $message = "Invalid username or password.";
            }
            $stmt->close();
        } else {
            $message = "Username and password are required.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/signup.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <style>
        .message-box {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 9999;
        }
    </style>
</head>
<body>
    <div class="main">      
        <input type="checkbox" id="chk" aria-hidden="true">
        <div class="signup">
            <form action="login.php" method="post">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="text" name="username" placeholder="Username" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <button type="submit">Login</button>
            </form>
            <center><p>Don't have an account? <a href="signup.php">Sign Up</a></p></center>
        </div>
    </div>
    <div class="message-box">
        <p><?php echo $message; ?></p>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var messageBox = document.querySelector('.message-box');
            if (messageBox.innerText.trim() !== '') {
                messageBox.style.display = 'block';
                setTimeout(function() {
                    messageBox.style.display = 'none';
                }, 2000); 
            }
        });
    </script>
</body>
</html>
