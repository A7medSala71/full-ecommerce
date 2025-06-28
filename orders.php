<?php
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true;

// Database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecomerce";

// Create the database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!$isLoggedIn) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];  // Assuming the user's ID is stored in session
$username = $_SESSION['username'];  // Assuming the user's username is stored in session

// Retrieve orders
if ($username === 'admin') {
    // Admin can view all orders
    $sql = "SELECT * FROM orders";
} else {
    // Regular user can only view their own orders
    $sql = "SELECT * FROM orders WHERE user_id = ?";
}

$stmt = $conn->prepare($sql);

// If the user is not an admin, bind the user ID to the query
if ($username !== 'admin') {
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <title>Welcome To Our
    Zero STORE
  </title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>
<body>
<div class="hero_area">
<!-- header section starts -->
<header class="header_section">
  <nav class="navbar navbar-expand-lg custom_nav-container ">
    <a class="navbar-brand" href="index.php">
      <span>
        Your Orders
      </span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class=""></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Toys.php">Toys</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Furniture.php">Furniture</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Camp.php">Camp</a>
        </li>
        <?php if ($isLoggedIn): ?>
          <li class="nav-item">
            <a class="nav-link" href="orders.php">Orders</a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link" href="why.php">Why Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact Us</a>
        </li>
      </ul>
      <div class="user_option">
        <?php if ($isLoggedIn): ?>
          <a href="logout.php">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
            <span>Logout</span>
          </a>
        <?php else: ?>
          <a href="login.php">
            <i class="fa fa-user" aria-hidden="true"></i>
            <span>Login</span>
          </a>
        <?php endif; ?>
        <a href="add_to_cart.php">
          <i class="fa fa-shopping-bag" aria-hidden="true"></i>
        </a>
        <div class="search-container">
          <form action="search.php" method="get">
            <input type="text" placeholder="Search.." name="query">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>
        </div>
      </div>
    </div>
  </nav>
</header>
<!-- header section ends -->

    <section class="slider_section">
      <div class="slider_container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-7">
                    <div class="detail-box">
                      <h3>
                        Welcome To Our <br>
                        Zero Store Shop
                      </h3>
                      <p>
                        Explore a magical world of enchanting tales, delightful characters, and heartwarming adventures designed to captivate the imagination of your little ones.
                      </p>
                      <a href="">
                        Contact Us
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item ">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-7">
                    <div class="detail-box">
                      <h3>
                        Welcome To Our <br>
                        zero Store Shop
                      </h3>
                      <p>
                        Explore a magical world of enchanting tales, delightful characters, and heartwarming adventures designed to captivate the imagination of your little ones.
                      </p>
                      <a href="">
                        Contact Us
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item ">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-7">
                    <div class="detail-box">
                      <h3>
                        Welcome To Our <br>
                        zero Store Shop
                      </h3>
                      <p>
                        Explore a magical world of enchanting tales, delightful characters, and heartwarming adventures designed to captivate the imagination of your little ones.
                      </p>
                      <a href="">
                        Contact Us
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel_btn-box">
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <i class="fa fa-arrow-left" aria-hidden="true"></i>
              <span class="sr-only">Previous</span>
            </a>
            <img src="images/line.png" alt="" />
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <i class="fa fa-arrow-right" aria-hidden="true"></i>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
      </div>
    </section>
  </div>
  <section class="shop_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Orders</h2>
        </div>
        <div class="Orders">
        <?php if (!empty($orders)): ?>
    <table border="1">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Full Name</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($order['address']); ?></td>
                    <td><?php echo htmlspecialchars($order['phone_number']); ?></td>
                    <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                    <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>You have no orders.</p>
<?php endif; ?>
        </div>
    </div>
</section>

<style>
    .Orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .Orders-table th, .Orders-table td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .Orders-table th {
        background-color: #f4f4f4;
    }

    .Orders-table img {
        max-width: 100px;
        height: auto;
    }

    .Orders-action .btn {
        padding: 5px 10px;
        border: none;
        color: #fff;
        background-color: #d9534f;
        cursor: pointer;
    }

    .Orders-action .btn:hover {
        background-color: #c9302c;
    }
    
    .Orders-image {
        text-align: center;
    }
    
    .Orders-name, .Orders-price {
        text-align: left;
    }
</style>

<section class="info_section  layout_padding2-top">
    <div class="social_container">
      <div class="social_box">
        <a href="">
          <i class="fa fa-facebook" aria-hidden="true"></i>
        </a>
        <a href="">
          <i class="fa fa-twitter" aria-hidden="true"></i>
        </a>
        <a href="">
          <i class="fa fa-instagram" aria-hidden="true"></i>
        </a>
        <a href="">
          <i class="fa fa-youtube" aria-hidden="true"></i>
        </a>
      </div>
    </div>
    <div class="info_container ">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-3">
            <h6>
              ABOUT US
            </h6>
            <p>
              Welcome to our Baby Stories Shop, where enchanting tales and heartwarming adventures await your little ones!... 
            </p>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="info_form ">
              <h5>
                Questions?
              </h5>
              <form action="#">
                <input type="email" placeholder="Enter your email">
                <button>
                  Subscribe
                </button>
              </form>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <h6>
              NEED HELP
            </h6>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
            </p>
          </div>
          <div class="col-md-6 col-lg-3">
            <h6>
              CONTACT US
            </h6>
            <div class="info_link-box">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span> Saudi Arabia </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>966 3676567890</span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span> demo@gmail.com</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    

  </section>

  <!-- end info section -->


  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <script src="js/custom.js"></script>

</body>
</html>
