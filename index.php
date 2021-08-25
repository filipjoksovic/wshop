<?php 
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    $_SESSION['user']['username'] = null;
    $_SESSION['user']['type'] = "gost";
    $_SESSION['cart'] = [];

    header("location: pocetna.php");
?>