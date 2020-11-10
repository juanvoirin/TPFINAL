<?php

    namespace Controllers;

    use DAO\CinemaDAO as CinemaDAO;
    use Models\Cinema as Cinema;
    use DAO\UserDAO as UserDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\MovieDAO as MovieDAO;
    use \Exception as Exception;
    

    class CinemaController
    {

        private $cinemaDao;

        public function index($message = ""){

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

        public function showListViewAll($message = ""){

            try{

                $all = TRUE;

                $this->cinemaDao = new CinemaDAO();
                $cinemasListAll = array();
                $cinemasListAll = $this->cinemaDao->getAll();

            }catch(Exception $e){
                $message = "No fue posible establecer una conexion con la Base de Datos.";
            }

            require_once(VIEWS_PATH."user-list-cinemas.php");
        }

        public function showListViewByOwner(){

            try{
                if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator"){

                    $all = FALSE;
                    
                    $userDao = new UserDAO();

                    $this->cinemaDao = new CinemaDAO();
                    $cinemasListAll = array();
                    $cinemasListAll = $this->cinemaDao->getByOwnerId($userDao->getByEmail($_SESSION["loggedUser"])->getId());
                }else{
                    $this->index();
                }

            }catch(Exception $e){
                $message = "No fue posible establecer una conexion con la Base de Datos.";
            }

            require_once(VIEWS_PATH."user-list-cinemas.php");
        }

        public function addCinemaForm(){

            try{
                if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator"){
                
                    require_once(VIEWS_PATH."adm-form-cinemas.php");
                }else{
                    $this->index();
                }

            }catch(Exception $e){
                $this->showListViewAll("Ocurrio un error en la redireccion hacia el formulario para un nuevo cinema.");
            }
        }

        public function addCinema($name, $address){

            try{
                if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator"){
                    $userDao = new UserDAO();
                
                    $cinema = new Cinema();
                    $cinema->setName($name);
                    $cinema->setAddress($address);
                    $cinema->setOwner($userDao->getByEmail($_SESSION["loggedUser"]));

                    $this->cinemaDao = new CinemaDAO();
                    $this->cinemaDao->add($cinema);

                    $this->showListViewAll("Cinema agregado correctamente.");
                }else{
                    $this->index();
                }

            }catch(Exception $e){
                $this->showListViewAll("Ocurrio un error al intentar agregar el nuevo cinema.");
            }
        }

        public function deleteCinema($id){
            
            try{
                if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator"){
                    $this->cinemaDao = new CinemaDAO();
                    $this->cinemaDao->deleteById($id);

                    $this->showListViewAll("Cinema eliminado correctamente.");
                }else{
                    $this->index();
                }

            }catch(Exception $e){
                $this->showListViewAll("Ocurrio un error al eliminar el cinema seleccionado.");
            }
        }

        public function updateToFormCinema($id){

            try{
                if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator"){
                    $this->cinemaDao = new CinemaDAO();
                    $cinema = $this->cinemaDao->getById($id);
                
                    require_once(VIEWS_PATH."adm-update-form-cinemas.php");
                }else{
                    $this->index();
                }

            }catch(Exception $e){
                $this->showListViewAll("Ocurrio un error en la redireccion para actualizar el cinema.");
            }
        }
        
        public function updateCinema($id, $name, $address, $idOwner){
            
            try{
                if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator"){
                    
                    $this->cinemaDao = new CinemaDAO();

                    $userDao = new UserDAO();

                    $cinema = new Cinema();
                    $cinema->setId($id);
                    $cinema->setName($name);
                    $cinema->setAddress($address);
                    $cinema->setOwner($userDao->getById($idOwner));

                    $this->cinemaDao->update($cinema);

                    $this->updateCinema($id, $name, $address, $idOwner);

                    $this->showListViewAll("Cine actualizado correctamente.");
                }else{
                    $this->index();
                }

            }catch(Exception $e){
                $this->showListViewAll("Ocurrio un error al intentar actualizar el cinema.");
            }
        }

    }
?>