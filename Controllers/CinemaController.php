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

            $cinema = new Cinema();
            $cinema->setName($name);
            $cinema->setCapacity($capacity);
            $cinema->setAddress($address);
            $cinema->setPrice($price);
            $cinema->setOwner($_SESSION["userName"]);

            $this->cinemaDao = new CinemaDAO();
            $this->cinemaDao->add($cinema);

            $this->showListView();
        }

        public function deleteCinema($id){
            $this->cinemaDao = new CinemaDAO();
            $this->cinemaDao->deleteById($id);

            $this->showListView();
        }

        public function updateToFormCinema($id){
            $this->cinemaDao = new CinemaDAO();
            $cinema = $this->cinemaDao->getById($id);
            
            require_once(VIEWS_PATH."adm-update-form-cinemas.php");
        }
        
        public function updateCinema($id, $name, $capacity, $address, $price, $owner){
            $this->cinemaDao = new CinemaDAO();
            $this->cinemaDao->update($id, $name, $capacity, $address, $price, $owner);
            
            $this->showListView();
        }

    }
?>