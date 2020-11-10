<?php

    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use Models\Movie as Movie;
    use DAO\GenreDAO as GenreDAO;
    use \Exception as Exception;

    class MovieController
    {
        private $movieDao;

        public function index ($message = ""){

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

        public function showListByGenre($idGenre){
            
            try{
                
                $this->genreDao = new GenreDAO();

                $genreList = array();
                $genreList = $this->genreDao->getAll();

                $this->movieDao = new MovieDAO();
                $movieList = array ();
                $movieList = $this->movieDao->getMoviesWithScreeningsByIdGenre($idGenre);
            
            }catch(Exception $e){
                $message = "No fue posible establecer una conexion con la Base de Datos.";
            }
            
            require_once(VIEWS_PATH."home.php");
        }

        public function showListByDate($date){

            try{

                $this->genreDao = new GenreDAO();

                $genreList = array();
                $genreList = $this->genreDao->getAll();

                $this->movieDao = new MovieDAO();

                $movieList = array();
                $movieList = $this->movieDao->getMovieWithScreeningByDate($date);

            }catch(Exception $e){
                $message = "No fue posible establecer una conexion con la Base de Datos.";
            }

            require_once(VIEWS_PATH."home.php");
        }

        public function showListView(){

            try{

                $this->genreDao = new GenreDAO();

                $genreList = array();
                $genreList = $this->genreDao->getAll();

                $this->movieDao = new MovieDAO();

                $movieList = array();
                $movieList = $this->movieDao->getMovieWithScreening();
            
            }catch(Exception $e){
                $message = "No fue posible establecer una conexion con la Base de Datos.";
            }

            require_once(VIEWS_PATH."home.php");
        }

        public function showAddView(){

            try{
                if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator"){
                    $this->genreDao = new GenreDAO();

                    $genreList = array();
                    $genreList = $this->genreDao->getAll();

                    $this->movieDao = new MovieDAO();

                    $movieList = array();
                    $movieList = $this->movieDao->getAllAPI();

                    require_once(VIEWS_PATH."adm-add-movies.php");
                }else{
                    $this->index();
                }
            
            }catch(Exception $e){
                $this->showListView("Ocurrio un error al traer las peliculas de la API.");
            }
        } 
        
    
    }
?>