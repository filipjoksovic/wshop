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
?>