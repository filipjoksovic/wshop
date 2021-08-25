<?php 
    require "db.php";
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_POST['register'])){
        $username = $_POST['username'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = md5($password);
        $type = $_POST['type'];
        $query = "SELECT * FROM users WHERE username = '{$username}' OR email = '{$email}'";
        $results = $database->query($query)->fetch_assoc();
        if($results != null){
            $_SESSION['error'] = "Korisnik sa ovim korisnickim imenom ili email adresom vec postoji";
            header("location: register.php");
            return;
        }
        $query = "INSERT INTO users VALUES('{$username}','{$fname}','{$lname}','{$email}','{$password}','{$type}')";
        if($database->query($query) === TRUE){
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['type'] = $type;
            header("location: pocetna.php");
            return;
        }
    }
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $query = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";
        $user = $database->query($query)->fetch_assoc();
        if($user == null){
            $_SESSION['error'] = "Greska pri prijavljivanju. Proverite ponovo korisnicko ime i/ili lozinku";
            header("location:login.php");
            return;
        }
        else{
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['type'] = $user['type'];
            header("location:pocetna.php");
            return;
        }
    }
    if(isset($_POST['add_product'])){
        $product_name = $_POST["pname"];
        $price = $_POST['price'];
        $username = $_POST['username'];
        $category;
        if($_POST['cat'] == -1){
            $category = $_POST['catManual'];
        }
        else{
            $category = $_POST['cat'];
        }
        $category = strtolower($category);
        $query = "INSERT INTO products (name,price,category,seller) VALUES ('${product_name}',{$price},'{$category}','{$username}')";
        $index = 0;
        if($database->query($query) === TRUE){
            //dodavanje fajlova u folder sa slikama
            $total = count($_FILES['images']['name']);
            $product_id = $database->insert_id;
            for($i=0; $i<$total; $i++) {
                $tmpFilePath = $_FILES['images']['tmp_name'][$i];
                
                if ($tmpFilePath != ""){
                    $newFilePath = "./media/" . $_FILES['images']['name'][$i];
                    $query = "INSERT INTO product_images VALUES({$product_id},'{$newFilePath}')";
                    if($database->query($query) != TRUE){
                        $_SESSION['error'] = "Greska prilikom cuvanja slike proizvoda u bazi podataka. Tekst greske: ".$database->error;
                        header("location:pocetna.php");
                        return;
                    }
                    else{
                        move_uploaded_file($tmpFilePath, $newFilePath);
                        $_SESSION['message'] = "Uspesno dodavanje proizvoda u bazu podataka";
                        header("location: pocetna.php");
                    }
                }
            }
        }
        else{
            
            $_SESSION['error'] = $query;
            // $_SESSION['error'] = "Greska prilikom dodavanja proizvoda u bazu podataka. Tekst greske: " . $database->error;
            header("location: pocetna.php");
            return;
        }
    }
    if(isset($_POST['edit_product'])){
        $product_name = $_POST["pname"];
        $price = $_POST['price'];
        $username = $_POST['username'];
        $product_id = $_POST['product_id'];
        $category;
        if ($_POST['cat'] == -1) {
            $category = $_POST['catManual'];
        } else {
            $category = $_POST['cat'];
        }
        $category = strtolower($category);

        $query = "UPDATE products SET name = '{$product_name}',price = '{$price}', category = '{$category}' WHERE id = {$product_id}";

        if($database->query($query) === TRUE){
            $_SESSION['message'] = "Uspesno izmenjen proizvod";
            header("location:pocetna.php");
            return;
        }
        else{
            $_SESSION['error'] = "Greska prilikom izmene proizvoda";
            header("location:pocetna.php");
            return;
        }
    }
?>