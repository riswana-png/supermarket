<?php 
    session_start();
    ob_start();
    if (!isset($_SESSION["adminauth"]) ||  $_SESSION["adminauth"] !== true) {
        // Redirect to login or take appropriate action
        // var_dump($_SESSION["adminauth"]);
        header("Location: ./index.html");
        exit();
    }
    ob_end_flush();
?>