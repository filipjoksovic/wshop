<?php 
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    $_SESSION['user']['username'] = null;
    $_SESSION['user']['type'] = "gost";

    header("location: pocetna.php");
?>