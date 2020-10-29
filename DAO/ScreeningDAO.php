<?php

    namespace DAO;

    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use DAO\UserDAO as UserDAO;
    use Models\Screening as Screening;
    use DAO\IScreeningDAO as IScreeningDAO;


    class ScreeningDAO implements IScreeningDAO 
    {

        private $connection;
        private $tableName = "screenings";


        public function getCinemaByDateAndMovie($idMovie, $date){

            //HACER LA SENTENCIA Y EN EL WHERE PONER LA DOBLE CONDICION.
            //TAMBIEN HACER QUE SI NO HAY NINGUN CINE QUE CUMPLA LOS DOS REQUISITOS QUE DEVUELVA NULL

            return NULL; //Este return es para probar, despues cambiarlo
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
                $screening->setIdRoom($roomDao->getById($row['id_room']));
                $screening->setIdMovie($movieDao->getById($row['id_movie']));

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
                $screening->setIdRoom($roomDao->getById($row['id_room']));
                $screening->setIdMovie($movieDao->getById($row['id_movie']));

                array_push($this->screeningsList, $screening);
            }
            return $this->screeningsList;
            

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
                $screening = new Screening();
                $screening->setId($row['id']);
                $screening->setDate($row['date']);
                $screening->setTime($row['time']);
                $screening->setRuntime($row['runtime']);
                $screening->setSold($row['sold']);
                $screening->setIdRoom($roomDao->getById($row['id_room']));
                $screening->setIdMovie($movieDao->getById($row['id_movie']));

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
            $parameters["id_room"] = $screening->getIdRoom();
            $parameters["id_movie"] = $screening->getIdMovie();

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

    }
?>