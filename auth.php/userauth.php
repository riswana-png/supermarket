<?php 
    session_start();
    if(!isset($_SESSION["userauth"]) ||  $_SESSION["userauth"] !== true){
        // var_dump($_SESSION["userauth"]);
        header("Location: ./index.html");
        exit();
    }
    
?>

model code add in each of the user pages 

<?php
include ("./auth/userauth.php");
?>