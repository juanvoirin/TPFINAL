<?php
    namespace Controllers;

    class HomeController
    {
        public function index($message = "")
        {
            if(!isset($_SESSION["loggedUser"])){
                $this->showLoginView();
            }else{
                $this->showHomeView();
            }
        }

        public function showLoginView(){
            require_once(VIEWS_PATH."login.php");
        }

        public function showHomeView(){
            require_once(VIEWS_PATH."home.php");
        }

        public function showRegisterView(){ 
            require_once(VIEWS_PATH."register.php");
        }
    }

?>