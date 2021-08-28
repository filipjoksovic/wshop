<?php
    require "db.php";
    require "SessionActions.php";
    SessionActions::startSession();
    $username = $_SESSION['user']['username'];
    $product_id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = {$product_id}";
    $product = $database->query($query)->fetch_assoc();
    if($product['seller'] != $username){
        $_SESSION['error'] = "Nemate dozvolu za uklanjanje ovog proizvoda.";
        header("location: pocetna.php");
    }
    else{
        $query = "SELECT * from product_images WHERE product_id = {$product_id}";
        $images = $database->query($query)->fetch_all(MYSQLI_ASSOC);
        foreach($images as $image){
                var_dump($image);
                echo $image['path'];
                if(is_file($image['path'])){
                    unlink($image['path']);
                }
        $query = "DELETE FROM products where id = {$product_id}";
        if($database->query($query) === TRUE){
            $_SESSION['message'] = "Uspesno brisanje proizvoda iz baze podataka";
        }
        else{
            $_SESSION['error'] = "Greska prilikom brisanja proizvoda iz baze podataka. Tekst greske: ".$database->error;
            }
        }
        header("location:pocetna.php");
        return;
    }
?>