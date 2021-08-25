<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    $product_id = $_GET['id'];
    if (($key = array_search($product_id, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['message'] = "Uspesno uklonjen proizvod iz korpe";
        header("location: korpa.php");
        return;
    }
    else{
        $_SESSION['error'] = "Greska prilikom uklanjanja proizvoda iz korpe";
        header("location: korpa.php");
        return;
    }
?>