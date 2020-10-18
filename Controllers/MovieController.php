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

    
    }