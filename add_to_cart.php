<?php 
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    $product_id = $_GET['id'];
    if(!in_array($product_id, $_SESSION['cart'])){
        array_push($_SESSION['cart'],$product_id);
        $_SESSION['message'] = "Proizvod uspesno dodat u korpu";    
        header("location: pocetna.php");
        return ;
    }
    else{
        $_SESSION['error'] = "Proizvod je vec dodat u korpu";
        header("location:pocetna.php");
        return;
    }
?>
