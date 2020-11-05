<?php
    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use \Exception as Exception;

    class HomeController
    {
        private $movieDao;
        private $genreDao;

        public function index($message = "")
        {
            if(!isset($_SESSION["loggedUser"])){
                $this->showLoginView();
            }else{
                $this->showHomeView();
            }
        }

        public function showLoginView($message = ""){
            require_once(VIEWS_PATH."login.php");
        }

        public function showHomeView($message = ""){
            try{
                $genreDao = new GenreDAO();

                $genreList = array();
                $genreList = $genreDao->getAll();
                
                $movieDao = new MovieDAO();

                $movieList = array();
                $movieList = $movieDao->getMovieWithScreening();

            }catch(Exception $e){
                $message = "No fue posible establecer una conexion con la Base de Datos.";
            }

            require_once(VIEWS_PATH."home.php");
        }

        public function showRegisterView(){ 
            require_once(VIEWS_PATH."register.php");
        }
    }

?>