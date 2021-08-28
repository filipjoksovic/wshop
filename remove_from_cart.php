<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    $product_id = $_GET['id'];
    
?>