<?php

    namespace Controllers;

    use DAO\CinemaDAO as CinemaDAO;

    class CinemaController
    {

        private $cinemaDao;

        public function index(){
            require_once(VIEWS_PATH."home.php");
        }

        public function showListView(){

            $this->cinemaDao = new CinemaDAO();
            $cinemasListAll = array();
            $cinemasListAll = $this->cinemaDao->getAll();

            require_once(VIEWS_PATH."user-list-cinemas.php");
        }

        public function addCinemaForm(){
            require_once(VIEWS_PATH."adm-form-cinemas.php");
        }

        public function addCinema($name, $capacity, $address, $price){

            $this->cinemaDao = new CinemaDAO();
            $this->cinemaDao->add($name, $capacity, $address, $price, $_SESSION["userName"]);

            $this->showListView();
        }

        public function delete($id){
            $this->cinemaDao = new CinemaDAO();
            $this->cinemaDao->deleteById($id);

            $this->showListView();
        }
        

    }
?>