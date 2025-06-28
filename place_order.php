<?php
session_start();
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

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

// Redirect to login page if user is not logged in
if (!$isLoggedIn) {
    header('Location: login.php');
    exit();
}

// Get user ID from session (assuming it is stored after login)
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];  // Make sure to store 'id' in session during login
} else {
    // If user ID is not set, redirect to login page
    header('Location: login.php');
    exit();
}

// Add order to the 'orders' table when form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['full_name'], $_POST['address'], $_POST['payment_method'], $_POST['phone_number']) && !empty($_SESSION['cart'])) {
        
        $full_name = $_POST['full_name'];
        $address = $_POST['address'];
        $payment_method = $_POST['payment_method'];
        $phone_number = $_POST['phone_number'];
        $total_amount = 0;

        // Calculate the total amount
        foreach ($_SESSION['cart'] as $item) {
            $total_amount += $item['price'];
        }

        // Insert order into 'orders' table
        $sql = "INSERT INTO orders (user_id, total_amount, status, full_name, address, payment_method, phone_number) 
                VALUES (?, ?, 'Pending', ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("idssss", $user_id, $total_amount, $full_name, $address, $payment_method, $phone_number);  // Updated to "idssss"
        $stmt->execute();
        $order_id = $stmt->insert_id;
        $stmt->close();

        // Clear the cart after placing the order
        unset($_SESSION['cart']);

        // Redirect to orders page
        header('Location: orders.php');
        exit();
    } else {
        $error_message = "Please fill in all the required fields.";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];

    // Validate payment method specific fields
    if ($payment_method === 'credit_card') {
        if (empty($_POST['credit_card_number']) || empty($_POST['expiration_date']) || empty($_POST['cvv'])) {
            $error_message = "Please enter all the required credit card details.";
        } elseif (!preg_match('/^\d{16}$/', $_POST['credit_card_number'])) {
            $error_message = "Invalid credit card number.";
        } elseif (!preg_match('/^\d{3,4}$/', $_POST['cvv'])) {
            $error_message = "Invalid CVV.";
        }
    } elseif ($payment_method === 'paypal') {
        if (empty($_POST['paypal_email']) || !filter_var($_POST['paypal_email'], FILTER_VALIDATE_EMAIL)) {
            $error_message = "Please enter a valid PayPal email address.";
        }
    } elseif ($payment_method === 'bank_transfer') {
        if (empty($_POST['bank_account_number']) || empty($_POST['iban'])) {
            $error_message = "Please enter your bank account details.";
        }
    }

    // If no errors, process the order
    if (!isset($error_message)) {
        // Order processing code goes here
    }
}


// Retrieve cart items
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2 class="my-4">Place Your Order</h2>

        <?php if (!empty($cartItems)): ?>
            <form action="place_order.php" method="post">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" required></textarea>
                </div>
                <div class="form-group">
                    <label for="phone_number">phone number</label>
                    <input type="number" class="form-control" id="phone_number" name="phone_number" required>
                </div>

                <div class="form-group">
                    <label for="payment_method">Payment Method</label>
                    <select class="form-control" id="payment_method" name="payment_method" required onchange="togglePaymentFields()">
                        <option value="">Select Payment Method</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="cash">Cash</option>
                    </select>
                 </div>
                 <div id="credit_card_fields" style="display:none;">
                    <div class="form-group">
                        <label for="credit_card_number">Credit Card Number</label>
                        <input type="text" class="form-control" id="credit_card_number" name="credit_card_number">
                    </div>
                    <div class="form-group">
                        <label for="expiration_date">Expiration Date</label>
                        <input type="month" class="form-control" id="expiration_date" name="expiration_date">
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv">
                    </div>
                </div>

                <!-- Additional fields for PayPal -->
                <div id="paypal_fields" style="display:none;">
                    <div class="form-group">
                        <label for="paypal_email">PayPal Email</label>
                        <input type="email" class="form-control" id="paypal_email" name="paypal_email">
                    </div>
                </div>

                <!-- Additional fields for Bank Transfer -->
                <div id="bank_transfer_fields" style="display:none;">
                    <div class="form-group">
                        <label for="bank_account_number">Bank Account Number</label>
                        <input type="text" class="form-control" id="bank_account_number" name="bank_account_number">
                    </div>
                    <div class="form-group">
                        <label for="iban">IBAN</label>
                        <input type="text" class="form-control" id="iban" name="iban">
                    </div>
                </div>
                <h3>Cart Summary</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td>$<?php echo number_format($item['price'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Place Order</button>
                    <a href="index.php" class="btn btn-secondary">Back to Shopping</a>  <!-- Back button -->
                </div>
            </form>
        <?php else: ?>
            <p>Your cart is empty. <a href="add_to_cart.php">Go back to shopping.</a></p>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger mt-4">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
    </div>
    <script>
function togglePaymentFields() {
    var paymentMethod = document.getElementById("payment_method").value;
    document.getElementById("credit_card_fields").style.display = paymentMethod === "credit_card" ? "block" : "none";
    document.getElementById("paypal_fields").style.display = paymentMethod === "paypal" ? "block" : "none";
    document.getElementById("bank_transfer_fields").style.display = paymentMethod === "bank_transfer" ? "block" : "none";
}
</script>

</body>
</html>
