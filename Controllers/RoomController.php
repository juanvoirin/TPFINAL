<?php

    namespace Controllers;
    
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\RoomDAO as RoomDAO;
    use Models\Room as Room;

    class RoomController {

        private $roomDao;

        public function index(){
            require_once(VIEWS_PATH."home.php");
        }

        public function showRooms($id){
            $this->roomDao = new RoomDAO();

            $cinemaDao = new CinemaDAO();

            $cinema = $cinemaDao->getById($id);
            $roomList = $this->roomDao->getByCinemaId($id);

            require_once(VIEWS_PATH."user-list-rooms.php");
        }

        public function showAddRoom($idCinema){
            require_once(VIEWS_PATH."adm-form-room.php");
        }

    
        public function addRoom($idCinema, $name, $capacity, $price){
            $this->roomDao = new RoomDAO();

            $cinemaDao = new CinemaDAO();

            $room = new Room();
            $room->setName($name);
            $room->setCapacity($capacity);
            $room->setPrice($price);
            $room->setCinema($cinemaDao->getById($idCinema));

            $this->roomDao->add($room);
            
            $this->showRooms($idCinema);
        }

        public function deleteRoom($id, $idcinema){

            $this->roomDao = new RoomDao();
            $this->roomDao->deleteById($id);
            
            $this->showRooms($idcinema);

        }

        public function updateToFormRoom($id, $idcinema){
            $this->roomDao = new RoomDAO();
            $room = $this->roomDao->GetByid($id);

            require_once(VIEWS_PATH."adm-update-form.rooms.php");
        }

        public function updateRoom($id, $name, $capacity, $price, $idCinema){

            $this->roomDao = new RoomDAO();

            $cinemaDao = new CinemaDAO;

            $room = new Room();
            $room->setId($id);
            $room->setName($name);
            $room->setCapacity($capacity);
            $room->setPrice($price);
            $room->setCinema($cinemaDao->getById($idCinema));

            $this->roomDao->update($room);

            $this->showRooms($idCinema);

        }

    }
