<?php
// Start the session
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "supermarket_management_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch categories for the dropdown
$category_sql = "SELECT * FROM categories"; 
$category_result = mysqli_query($conn, $category_sql);

// Check if a category is selected for filtering
$selected_category = isset($_POST['category']) ? $_POST['category'] : '';

// Fetch products from the database, filtered by category if selected
$sql = "SELECT * FROM items";
if ($selected_category && $selected_category !== 'All Products') {
    // Sanitize the input to prevent SQL injection
    $selected_category = mysqli_real_escape_string($conn, $selected_category);
    $sql .= " WHERE category = '$selected_category'"; 
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="buyproduct.css"> <!-- Custom CSS -->
    <title>Buy Products</title>
</head>
<body>
<nav class="navbar">
    <h1>Super Market Management System</h1>
    <div class="Nav_menus">
        <a href="index.html"><div class="menus">Home</div></a>
        <a href="buy_products.php"><div class="menus">Buy</div></a>
        <a href="view_cart.php"><div class="menus">Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</div></a>
        <a href="logout.php"><div class="menus">Logout</div></a>
    </div>
</nav>

<section class="Home_Section">
    <h1>Available Products</h1>
    
    <!-- Category Filter Form -->
    <form method="POST" action="buy_products.php">
        <label for="category">Select Category:</label>
        <select name="category" id="category" onchange="this.form.submit()">
            <option value="All Products">All Products</option> 
            <?php
            if (mysqli_num_rows($category_result) > 0) {
                while ($category_row = mysqli_fetch_assoc($category_result)) {
                    $selected = ($category_row['category_name'] == $selected_category) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($category_row['category_name']) . '" ' . $selected . '>' . htmlspecialchars($category_row['category_name']) . '</option>';
                }
            }
            ?>
        </select>
    </form>
    
    <div class="container">
        <div class="product-grid">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $item_in_cart = false;
                    $current_quantity = 0;

                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as &$cart_item) {
                            if ($cart_item['id'] == $row['id']) {
                                $item_in_cart = true;
                                $current_quantity = $cart_item['quantity'];
                                break;
                            }
                        }
                    }

                    echo '<div class="product-card">';
                    echo '    <img src="' . htmlspecialchars($row['image_path']) . '" class="product-image" alt="Product Image">';
                    echo '    <div class="product-details">';
                    echo '        <h5 class="product-title">' . htmlspecialchars($row['name']) . '</h5>';
                    echo '        <p class="product-price">Price: Rs.' . htmlspecialchars($row['price']) . '</p>';

                    if ($row['quantity'] > 0) {
                        echo '        <p class="product-quantity">Available: ' . htmlspecialchars($row['quantity']) . '</p>';

                        if ($item_in_cart) {
                            echo '        <div class="quantity-controls">';
                            echo '            <form method="POST" action="update_cart.php">';
                            echo '                <input type="hidden" name="item_id" value="' . $row['id'] . '">';
                            echo '                <button type="submit" name="action" value="decrease" class="btn">-</button>';
                            echo '                <span>Quantity: ' . $current_quantity . '</span>';
                            echo '                <button type="submit" name="action" value="increase" class="btn">+</button>';
                            echo '            </form>';
                            echo '        </div>';
                        } else {
                            echo '        <form method="POST" action="add_to_cart.php">';
                            echo '            <input type="hidden" name="item_id" value="' . $row['id'] . '">';
                            echo '            <button type="submit" class="btn">Add to Cart</button>';
                            echo '        </form>';
                        }
                    } else {
                        echo '        <p class="product-quantity out-of-stock">Out of Stock</p>';
                    }

                    echo '    </div>';
                    echo '</div>';
                }
            } else {
                echo "<p>No products available.</p>";
            }
            ?>
        </div>
    </div>
</section>
</body>
</html>

<?php
mysqli_close($conn);
?>
