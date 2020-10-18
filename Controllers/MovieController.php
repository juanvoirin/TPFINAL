<?php

    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use Models\Movie as Movie;

    class MovieController
    {
        private $movieDao;

        public function index (){
            require_once(VIEWS_PATH."home.php");
        }

        public function showListGenre($id){
            
            $this->movieDao = new MovieDAO();
            $MovieByGenre = array ();
            $MovieByGenre = $this->movieDao->getByGenreIds($id);
            
            //falta require_once

        }

        public function showListDate($date){

            $this->movieDao = new MovieDAO();
            $moviebydate = array();
            $moviebydate = $this->movieDao->getByDate($date);

            // falta requir_once
        }
        
    
    }