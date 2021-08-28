<?php
    class UserActions{
        static function getAllUsers(){
            require "db.php";
            $query = "SELECT * FROM users WHERE username != 'admin'";
            $users = $database->query($query);
            if($users != false){
                return $users->fetch_all(MYSQLI_ASSOC);
            }
            else{
                return [];
            }
        }
    }
?>