<?php

    namespace DAO;

    use Models\Room as Room;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use DAO\CinemaDAO as CinemaDAO;

    class RoomDAO {

        private $roomsList;
        private $connection;
        private $tableName = "rooms";
        
        public function getByCinemaId($cinemaId){

            $query = "CALL Rooms_GetByCinemaId(?)";

            $parameters["cinemaId"] = $cinemaId;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
            
            $this->roomsList = array();

            $cinemaDao = new CinemaDAO();

            foreach($result as $row){
                $room = new Room();
                $room->setId($row['id']);
                $room->setName($row['name']);
                $room->setPrice($row['price']);
                $room->setCapacity($row['capacity']);
                $room->setCinema($cinemaDao($row['idCinema']));

                array_push($this->roomsList, $room);
            }

            return $this->roomsList;
        }

        public function add(Room $room){

            $query = "CALL Rooms_Add(?, ?, ?, ?)";

            $parameters["name"] = $room->getName();
            $parameters["price"] = $room->getPrice();
            $parameters["capacity"] = $room->getCapacity();
            $parameters["idCinema"] = $room->getCinema()->getId();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

    }

?>