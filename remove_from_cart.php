<?php
session_start();

if (isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $cart_item) {
            if ($cart_item['id'] == $item_id) {
                unset($_SESSION['cart'][$key]);  
                break;  
            }
        }

        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    header("Location: view_cart.php");
    exit();
} else {
    header("Location: view_cart.php");
    exit();
}
?>
