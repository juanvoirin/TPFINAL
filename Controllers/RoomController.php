<?php

    namespace Controllers;
    
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\RoomDAO as RoomDAO;
    use Models\Room as Room;
    use DAO\GenreDAO as GenreDAO;
    use DAO\MovieDAO as MovieDAO;
    use \Exception as Exception;

    class RoomController {

        private $roomDao;

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

        public function showRooms($id, $message = ""){

            try{
                
                $this->roomDao = new RoomDAO();

                $cinemaDao = new CinemaDAO();

                $cinema = $cinemaDao->getById($id);
                
                $roomList = array();
                $roomList = $this->roomDao->getByCinemaId($id);

                require_once(VIEWS_PATH."user-list-rooms.php");

            }catch(Exception $e){
                $cinemaController = new CinemaController();
                $cinemaController->showListViewAll("No fue posible establecer una conexion con la Base de Datos.");
            }
        }

        public function showAddRoom($idCinema){
            
            try{
                $cinemaDao = new CinemaDAO();

                $cinema = $cinemaDao->getById($idCinema);

                require_once(VIEWS_PATH."adm-form-room.php");

            }catch(Exception $e){
                $this->showRooms($idCinema, "Ocurrio un error en la redireccion al formulario de una nueva sala.");
            }
        }

    
        public function addRoom($idCinema, $name, $capacity, $price){
            
            try{
                $this->roomDao = new RoomDAO();

                $cinemaDao = new CinemaDAO();

                $room = new Room();
                $room->setName($name);
                $room->setCapacity($capacity);
                $room->setPrice($price);
                $room->setCinema($cinemaDao->getById($idCinema));

                $this->roomDao->add($room);
                
                $this->showRooms($idCinema, "Sala agregada correctamente.");

            }catch(Exception $e){
                $this->showRooms($idCinema, "Ocurrio un error al agregar la sala.");
            }
        }

        public function deleteRoom($id, $idCinema){

            try{
                $this->roomDao = new RoomDao();
                $this->roomDao->deleteById($id);
                
                $this->showRooms($idCinema, "Sala eliminada correctamente.");

            }catch(Exception $e){
                $this->showRooms($idCinema, "Ocurrio un error al eliminar la sala.");
            }
        }

        public function updateToFormRoom($id, $idCinema){

            try{

                $this->roomDao = new RoomDAO();
                $room = $this->roomDao->GetByid($id);

                $cinemaDao = new CinemaDAO();
                $cinema = $cinemaDao->getById($idCinema);

                require_once(VIEWS_PATH."adm-update-form-rooms.php");

            }catch(Exception $e){
                $this->showRooms($idCinema, "Ocurrio un error en la redireccion al formulario de actualizacion de la sala.");
            }
        }

        public function updateRoom($id, $name, $capacity, $price, $idCinema){

            try{
                $this->roomDao = new RoomDAO();

                $cinemaDao = new CinemaDAO;

                $room = new Room();
                $room->setId($id);
                $room->setName($name);
                $room->setCapacity($capacity);
                $room->setPrice($price);
                $room->setCinema($cinemaDao->getById($idCinema));

                $this->roomDao->update($room);

                $this->showRooms($idCinema, "Sala actualizada correctamente.");

            }catch(Exception $e){
                $this->showRooms($idCinema, "Ocurrio un error al actualizar la sala.");
            }

        }

    }
?>
