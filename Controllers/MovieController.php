<?php

    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use Models\Movie as Movie;
    use DAO\GenreDAO as GenreDAO;

    class MovieController
    {
        private $movieDao;

        public function index (){
            $genreDao = new GenreDAO();

            $genreList = array();
            $genreList = $genreDao->getAll();
            
            $movieDao = new MovieDAO();

            $movieList = array();
            $movieList = $movieDao->getMovieWithScreening();

            require_once(VIEWS_PATH."home.php");
        }

        public function showListByGenre($idGenre){
            
            $this->genreDao = new GenreDAO();

            $genreList = array();
            $genreList = $this->genreDao->getAll();

            $this->movieDao = new MovieDAO();
            $movieList = array ();
            $movieList = $this->movieDao->getByGenreIds($idGenre);
            
            require_once(VIEWS_PATH."home.php");
        }

        public function showListByDate($date){

            $this->genreDao = new GenreDAO();

            $genreList = array();
            $genreList = $this->genreDao->getAll();

            $this->movieDao = new MovieDAO();

            $movieList = array();
            $movieList = $this->movieDao->getByDate($date);

            require_once(VIEWS_PATH."home.php");
        }

        public function showListView(){

            $this->genreDao = new GenreDAO();

            $genreList = array();
            $genreList = $this->genreDao->getAll();

            $this->movieDao = new MovieDAO();

            $movieList = array();
            $movieList = $this->movieDao->getMovieWithScreening();

            require_once(VIEWS_PATH."home.php");
        }

        public function showAddView(){

            $this->genreDao = new GenreDAO();

            $genreList = array();
            $genreList = $this->genreDao->getAll();

            $this->movieDao = new MovieDAO();

            $movieList = array();
            $movieList = $this->movieDao->getAllAPI();

            require_once(VIEWS_PATH."adm-add-movies.php");
        } 
        
    
    }
?>