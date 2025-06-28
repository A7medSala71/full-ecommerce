<?php
session_start();  // Start session at the top of the page

// Check if user is logged in
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true;
// Check if user is an admin
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true;
?>
<!DOCTYPE html>
<html>

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
        <h2>Our Camp Products</h2>
      </div>
      <div class="row">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ecomerce";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Modify the SQL query to filter products belonging to the "Camp" category
        $sql = "SELECT product.*, categories.name AS category_name 
                FROM product 
                INNER JOIN categories ON product.category_id = categories.Id 
                WHERE product.category_id = 3"; //  category ID 3 for Toys
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $productName = $row["name"];
            $productPrice = $row["price"];
            $productImage = $row["image"];
            $productId = $row["id"]; // Get the product ID for editing and deleting
        ?>
            <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="box">
                    <a href="">
                        <div class="img-box">
                            <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>">
                        </div>
                        <div class="detail-box">
                            <h6><?php echo $productName; ?></h6>
                            <h6>Price <span><?php echo $productPrice; ?></span></h6>
                        </div>
                        <div class="new">
                            <span>New</span>
                        </div>
                    </a>

                    <?php if ($isAdmin): ?>
                    <div class="admin-buttons">
                        <!-- Edit Button Form -->
                        <form action="edit.php" method="POST" style="display:inline;">
                            <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                            <button type="submit">Edit</button>
                        </form>
                        <!-- Delete Button Form -->
                        <form action="delete.php" method="POST" style="display:inline;">
                            <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                    <?php elseif ($isLoggedIn && !$isAdmin): ?>
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="productName" value="<?php echo $productName; ?>">
                        <input type="hidden" name="productPrice" value="<?php echo $productPrice; ?>">
                        <input type="hidden" name="productImage" value="<?php echo $productImage; ?>">
                        <button type="submit">Add to Cart</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php
          }
        } else {
          echo "0 results";
        }
        $conn->close();
        ?>
      </div>

      <?php if ($isAdmin): ?>
        <div class="btn-box">
          <a href="add.php">Add New Product</a>
        </div>
      <?php endif; ?>

    </div>
  </section>

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