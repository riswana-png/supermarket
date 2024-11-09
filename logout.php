<?php
session_start();
// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Unset all session variables
    $_SESSION = []; 
    // Destroy the session
    session_destroy(); 
    // Set a message for the logout
    $message = "You have been logged out successfully.";
} else {
    $message = "You are not logged in.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="logout.css">
    <title>Logout</title>
</head>
<body>
    <div class="logout-container">
        <h1>Logout</h1>
        <p><?php echo $message; ?></p>
        <a href="login.php" class="back-button">Back to Login</a>
    </div>
</body>
</html>
