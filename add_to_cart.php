<?php 
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    $product_id = $_GET['id'];
    if(!array_key_exists($product_id,$_SESSION['cart'])){
        $_SESSION['cart'][$product_id] = 1;
    }
    else{
        $_SESSION['cart'][$product_id]++;
    }
    $_SESSION['message'] = "Proizvod je uspesno dodat u korpu";
    header("location:pocetna.php");

?>
