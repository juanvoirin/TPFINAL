<?php
    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;

    class HomeController
    {
        private $movieDao;
        private $genreDao;

        public function index()
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
            $this->genreDao = new GenreDAO();

            $genreList = array();
            $genreList = $this->genreDao->getAll();
            
            $this->movieDao = new MovieDAO();

            $movieList = array();
            $movieList = $this->movieDao->getAllAPI(); //CAMBIAR ESTO Y MOSTRAR LAS PELICULAS QUE TENGAN FUNCIONES

            require_once(VIEWS_PATH."home.php");
        }

        public function showRegisterView(){ 
            require_once(VIEWS_PATH."register.php");
        }
    }

?>