<?php 
    class SessionActions{
        public static function startSession(){
            if(session_status() === PHP_SESSION_NONE){
                session_start();
            }
        }
        public static function renderMessages(){
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>Greska!</strong> '.$_SESSION['error'].'
                    </div>';
                    unset($_SESSION["error"]);
            }
            if (isset($_SESSION['message'])){
                echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>Uspeh!</strong> '.$_SESSION['message'].'
                    </div>';
                unset($_SESSION["message"]);
            }    
        }
    }
?>