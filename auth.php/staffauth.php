<?php 
    session_start();
    ob_start();
    if (!isset($_SESSION["staffauth"]) ||  $_SESSION["staffauth"] !== true) {
        // Redirect to login or take appropriate action
        // var_dump($_SESSION["adminauth"]);
        header("Location: ./index.html");
        exit();
    }
    ob_end_flush();
?>