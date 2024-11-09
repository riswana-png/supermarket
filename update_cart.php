<?php
session_start();

if (isset($_POST['item_id']) && isset($_POST['action'])) {
    $item_id = $_POST['item_id'];
    $action = $_POST['action'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['id'] == $item_id) {
                if ($action == 'increase') {
                    $cart_item['quantity'] += 1;
                }
                elseif ($action == 'decrease' && $cart_item['quantity'] > 1) {
                    $cart_item['quantity'] -= 1;
                }
                break; 
            }
        }
    }

    header("Location: buy_products.php");
    exit();
} else {
    header("Location: buy_products.php?error=invalid_action");
    exit();
}
