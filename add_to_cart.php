<?php
session_start();
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true;

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

// Add product to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['productName']) && isset($_POST['productPrice']) && isset($_POST['productImage'])) {
        $productName = $_POST['productName'];
        $productPrice = $_POST['productPrice'];
        $productImage = $_POST['productImage'];

        // Add product to the cart session
        $_SESSION['cart'][] = [
            'name' => $productName,
            'price' => $productPrice,
            'image' => $productImage,
        ];
    } elseif (isset($_POST['delete']) && isset($_POST['productName'])) {
        $productName = $_POST['productName'];

        // Remove the product from the session cart
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['name'] === $productName) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }

        // Re-index the session array
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

// Proceed to checkout (place order)
if (isset($_POST['checkout']) && !empty($_SESSION['cart'])) {
    // Ensure user is logged in
    if (!$isLoggedIn) {
        header('Location: login.php');
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $total_amount = 0;

    // Calculate total amount
    foreach ($_SESSION['cart'] as $item) {
        $total_amount += $item['price'];
    }

    // Insert order into 'orders' table
    $sql = "INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $user_id, $total_amount);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Insert items into 'order_items' table
    $sql = "INSERT INTO order_items (order_id, product_name, product_price, product_image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    foreach ($_SESSION['cart'] as $item) {
        $stmt->bind_param("isds", $order_id, $item['name'], $item['price'], $item['image']);
        $stmt->execute();
    }

    $stmt->close();

    // Clear cart session
    unset($_SESSION['cart']);

    // Redirect to orders page
    header('Location: orders.php');
    exit();
}

// Retrieve cart items
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$conn->close();
?>

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
        Zero STORIES
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
                        Zero Stor Shop
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
                        Baba Stories Shop
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
            <h2>Cart</h2>
        </div>
        <div class="cart">
            <?php if (!empty($cartItems)): ?>
                <form action="add_to_cart.php" method="post">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td class="cart-image">
                                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                    </td>
                                    <td class="cart-name"><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td class="cart-price">$<?php echo number_format($item['price'], 2); ?></td>
                                    <td class="cart-action">
                                        <form action="add_to_cart.php" method="post" style="display:inline;">
                                            <input type="hidden" name="productName" value="<?php echo htmlspecialchars($item['name']); ?>">
                                            <input type="hidden" name="delete" value="1">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- Checkout button -->
                    <form action="place_order.php" method="get">
    <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
</form>
                </form>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-table th, .cart-table td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .cart-table th {
        background-color: #f4f4f4;
    }

    .cart-table img {
        max-width: 100px;
        height: auto;
    }

    .cart-action .btn {
        padding: 5px 10px;
        border: none;
        color: #fff;
        background-color: #d9534f;
        cursor: pointer;
    }

    .cart-action .btn:hover {
        background-color: #c9302c;
    }
    
    .cart-image {
        text-align: center;
    }
    
    .cart-name, .cart-price {
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
