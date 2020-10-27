<?php

    namespace Controllers;

    use DAO\CinemaDAO as CinemaDAO;
    use Models\Cinema as Cinema;
    use DAO\UserDAO as UserDAO;

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

        public function addCinema($name, $address){

            $userDao = new UserDAO();
            
            $cinema = new Cinema();
            $cinema->setName($name);
            $cinema->setAddress($address);
            $cinema->setOwner($userDao->getByEmail($_SESSION["loggedUser"]));

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
        
        public function updateCinema($id, $name, $address, $idOwner){
            $this->cinemaDao = new CinemaDAO();

            $userDao = new UserDAO();

            $cinema = new Cinema();
            $cinema->setId($id);
            $cinema->setName($name);
            $cinema->setAddress($address);
            $cinema->setOwner($userDao->getByEmail($idOwner));

            $this->cinemaDao->update($cinema);
            
            $this->showListView();
        }

    }
?>