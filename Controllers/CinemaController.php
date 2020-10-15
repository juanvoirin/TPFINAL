<?php

    namespace Controllers;

    use DAO\CinemaDAO as CinemaDAO;
    use Models\Cinema as Cinema;

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

        public function deleteCinema($id){
            $this->cinemaDao = new CinemaDAO();
            $this->cinemaDao->deleteById($id);

            $this->showListView();
        }

        public function updateToFormCinema($id){
            $this->cinemaDao = new CinemaDAO();
            $cinema = $this->chinemaDao->getById($id);
            
            $name = $cinema->getName();
            $capacity = $cinema->getCapacity();
            $address = $cinema->getAddress();
            $price = $cinema->getPrice();
            $owner = $cinema->getOwner();

            require_once(VIEWS_PATH."adm-update-form-cinemas.php");
        }
        
        public function updateCinema($id, $name, $capacity, $address, $price, $owner){
            $this->cinemaDao = new CinemaDAO();
            $this->cinemaDao->update($id, $name, $capacity, $address, $price, $owner);
            
            $this->showListView();
        }

    }
?>