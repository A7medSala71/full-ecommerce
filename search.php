<?php
session_start();
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true;
$servername = "localhost";
$username = "root"; // Update with your database username
$password = ""; // Update with your database password
$dbname = "ecomerce"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$results = [];
$query = "";
$category_id = null;

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    if (isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
        $sql = "SELECT name, price, image FROM product WHERE name LIKE ? AND category_id = ?";
        $stmt = $conn->prepare($sql);
        $searchTerm = "%" . $query . "%";
        $stmt->bind_param("si", $searchTerm, $category_id);
    } else {
        $sql = "SELECT name, price, image FROM product WHERE name LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchTerm = "%" . $query . "%";
        $stmt->bind_param("s", $searchTerm);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
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
            <h2>Search</h2>
        </div>
        <div class="search-bar">
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search for products..." value="<?php echo htmlspecialchars($query); ?>">
                <?php if (isset($_GET['category_id'])): ?>
                    <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($_GET['category_id']); ?>">
                <?php endif; ?>
                <input type="submit" value="Search">
            </form>
        </div>

        <div class="results">
            <?php if (!empty($results)): ?>
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $product): ?>
                            <tr>
                                <td class="results-image">
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                </td>
                                <td class="results-name"><?php echo htmlspecialchars($product['name']); ?></td>
                                <td class="results-price">$<?php echo number_format($product['price'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-results">No products found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    .search-bar form {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .search-bar input[type="text"] {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px 0 0 5px;
        width: 300px;
        font-size: 16px;
    }

    .search-bar input[type="submit"] {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 0 5px 5px 0;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
        font-size: 16px;
    }

    .search-bar input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .results-table {
        width: 100%;
        border-collapse: collapse;
    }

    .results-table th, .results-table td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .results-table th {
        background-color: #f4f4f4;
    }

    .results-table img {
        max-width: 100px;
        height: auto;
    }

    .results-image {
        text-align: center;
    }

    .results-name, .results-price {
        text-align: left;
    }

    .no-results {
        text-align: center;
        font-size: 18px;
        color: #999;
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
</body>
</html>
