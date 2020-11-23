<?php

    namespace DAO;

    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use DAO\UserDAO as UserDAO;
    use Models\Screening as Screening;
    use DAO\IScreeningDAO as IScreeningDAO;
    use DateTime;


    class ScreeningDAO implements IScreeningDAO 
    {

        private $connection;
        private $tableName = "screenings";


        public function getCinemaByDateAndMovie($idMovie, $date){
            
            $query = "CALL Screenings_GetCinemaByDateAndMovie (?,?)";

            $parameters["date"] = $date;
            $parameters["id_movie"] = $idMovie;
            
            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            if ($result != NULL){
                foreach($result as $row){
                    $screening = new Screening();
                    $roomDao = new RoomDAO();
                    $movieDao = new MovieDAO();

                    $screening->setId($row['id']);
                    $screening->setDate($row['date']);
                    $screening->setTime($row['time']);
                    $screening->setRuntime($row['runtime']);
                    $screening->setSold($row['sold']);
                    $screening->setRoom($roomDao->getById($row['id_room']));
                    $screening->setMovie($movieDao->getById($row['id_movie']));
                }

                return $screening;
            }else{
                return NULL;
            }

        }

        public function getById($id)
        {
            $query = "CALL Screenings_GetById(?)";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $screening = new Screening();

            $roomDao = new RoomDAO();

            $movieDao = new MovieDAO();

            foreach($result as $row){
                $screening->setId($row['id']);
                $screening->setDate($row['date']);
                $screening->setTime($row['time']);
                $screening->setRuntime($row['runtime']);
                $screening->setSold($row['sold']);
                $screening->setRoom($roomDao->getById($row['id_room']));
                $screening->setMovie($movieDao->getById($row['id_movie']));

            }
            return $screening;

        }

        public function getByRoom($idRoom){

            $query = "CALL Screenings_GetByIdRoom(?)";

            $parameters["idRoom"] = $idRoom;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $this->screeningsList = array();

            $roomDao = new RoomDAO();

            $movieDao = new MovieDAO();

            foreach($result as $row){
                $screening = new Screening();
                $screening->setId($row['id']);
                $screening->setDate($row['date']);
                $screening->setTime($row['time']);
                $screening->setRuntime($row['runtime']);
                $screening->setSold($row['sold']);
                $screening->setRoom($roomDao->getById($row['id_room']));
                $screening->setMovie($movieDao->getById($row['id_movie']));

                array_push($this->screeningsList, $screening);
            }
            return $this->screeningsList;
            
        }

        public function getByRoomAndDate($idRoom, $date){

            $query = "CALL Screenings_GetByIdRoomAndDate(?, ?)";

            $parameters["idRoom"] = $idRoom;

            $parameters["date"] = $date;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $screeningsList = array();

            $roomDao = new RoomDAO();

            $movieDao = new MovieDAO();

            foreach($result as $row){
                $screening = new Screening();
                $screening->setId($row['id']);
                $screening->setDate($row['date']);
                $screening->setTime($row['time']);
                $screening->setRuntime($row['runtime']);
                $screening->setSold($row['sold']);
                $screening->setRoom($roomDao->getById($row['id_room']));
                $screening->setMovie($movieDao->getById($row['id_movie']));

                array_push($screeningsList, $screening);
            }
            return $screeningsList;
            
        }

        public function getAll()
        {
            $this->screeningsList = array();

            $query = "CALL Screenings_GetAll()";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
            
            $roomDao = new RoomDAO();

            $movieDao = new MovieDAO();

            foreach($result as $row){
                if($row['date'] >= date('Y-m-d')){
                    $screening = new Screening();
                    $screening->setId($row['id']);
                    $screening->setDate($row['date']);
                    $screening->setTime($row['time']);
                    $screening->setRuntime($row['runtime']);
                    $screening->setSold($row['sold']);
                    $screening->setRoom($roomDao->getById($row['id_room']));
                    $screening->setMovie($movieDao->getById($row['id_movie']));

                    array_push($this->screeningsList, $screening);
                }
            }
            return $this->screeningsList; 
        }

        public function getByOwner($idOwner)
        {
            $this->screeningsList = array();

            $query = "CALL Screenings_GetByOwner(?)";

            $parameters["idOwner"] = $idOwner;
            
            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
            
            $roomDao = new RoomDAO();

            $movieDao = new MovieDAO();

            foreach($result as $row){
                $screening = new Screening();
                $screening->setId($row['id']);
                $screening->setDate($row['date']);
                $screening->setTime($row['time']);
                $screening->setRuntime($row['runtime']);
                $screening->setSold($row['sold']);
                $screening->setRoom($roomDao->getById($row['id_room']));
                $screening->setMovie($movieDao->getById($row['id_movie']));

                array_push($this->screeningsList, $screening);
            }
            return $this->screeningsList; 
        }

        public function add(Screening $screening)
        {
            $query = "CALL Screenings_Add(?,?,?,?,?)";

            $parameters["date"] = $screening->getDate();
            $parameters["time"] = $screening->getTime();
            $parameters["runtime"] = $screening->getRuntime();
            $parameters["id_room"] = $screening->getRoom()->getId();
            $parameters["id_movie"] = $screening->getMovie()->getId();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            
            
        }

        public function deleteById($id)
        {
            $query = "CALL Screenings_Delete(?)";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

        public function getByIdMovie($idMovie){

            $query = "CALL Screenings_GetByIdMovie(?)";

            $parameters["id_movie"] = $idMovie;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $this->screeningsList = array();

            $roomDao = new RoomDAO();

            $movieDao = new MovieDAO();
            
            foreach ($result as $row){
                $screening = new Screening();
                $screening->setId($row['id']);
                $screening->setDate($row['date']);
                $screening->setTime($row['time']);
                $screening->setRuntime($row['runtime']);
                $screening->setSold($row['sold']);
                $screening->setRoom($roomDao->getById($row['id_room']));
                $screening->setMovie($movieDao->getById($row['id_movie']));

                array_push($this->screeningsList, $screening);

            }
            return $this->screeningsList ;

        }

        public function getFinishHourScreening($idRoom, $date){

            $query = "CALL Screenings_GetFinishHourScreening (?,?)";
            
            $parameters["id_room"] = $idRoom;
            $parameters["date"] = $date;
            
            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $screening = NULL;

            foreach($result as $row){

                if($row['id'] !=NULL){
                    $screening = new Screening();
                    $roomDao = new RoomDAO();
                    $movieDao = new MovieDAO();

                    $screening->setId($row['id']);
                    $screening->setDate($row['date']);
                    $screening->setTime($row['time']);
                    $screening->setRuntime($row['runtime']);
                    $screening->setSold($row['sold']);
                    $screening->setRoom($roomDao->getById($row['id_room']));
                    $screening->setMovie($movieDao->getById($row['id_movie']));
                }
            }

            return $screening;

        }

        public function sumSoldScreening($idScreening, $quantity){

            $query = "CALL Screenings_SumSoldScreening(?, ?)";

            $parameters["idScreening"] = $idScreening;
            $parameters["quantity"] = $quantity;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

        public function getCapacityByMovie($idMovie, $idOwner){

            $query = "CALL Screenings_GetCapacityByMovie(?, ?)";

            $parameters["idMovie"] = $idMovie;
            $parameters["idOwner"] = $idOwner;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            foreach($result as $row){
                $capacity = $row["capacity"];
            }

            return $capacity;
        }

        public function getCapacityByCinema($idCinema){

            $query = "CALL Screenings_GetCapacityByCinema(?)";

            $parameters["idCinema"] = $idCinema;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            foreach($result as $row){
                $capacity = $row["capacity"];
            }

            return $capacity;
        }

    }
?>