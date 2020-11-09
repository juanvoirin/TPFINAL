<?php

    namespace DAO;

    use Models\Cinema as Cinema;
    use DAO\ICinemaDAO as ICinemaDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use DAO\UserDAO as UserDAO;


    class CinemaDAO implements ICinemaDAO
    {

        private $cinemasList = array();
        private $connection;
        private $tableName = "cinemas";


        public function getByOwnerId($ownerId)
        {
            
            $query = "CALL Cinemas_GetByOwnerId(?)";

            $parameters["ownerId"] = $ownerId;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $this->cinemasList = array();

            $userDao = new UserDAO();

            foreach ($result as $row){
                $cinema = new Cinema();
                $cinema->setId($row['id']);
                $cinema->setName($row['name']);
                $cinema->setAddress($row['address']);
                $cinema->setOwner($userDao->getById($row['owner']));

                array_push($this->cinemasList, $cinema);
            }
            return $this->cinemasList;
        }

        public function getById($id)
        {

            $query = "CALL Cinemas_GetById(?)";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $cinema = new Cinema();

            $userDao = new UserDAO();

            foreach ($result as $row){
                $cinema->setId($row['id']);
                $cinema->setName($row['name']);
                $cinema->setAddress($row['address']);
                $cinema->setOwner($userDao->getById($row['owner']));
            }
            return $cinema;
        }

        public function getAll()
        {
            $this->cinemasList = array();

            $query = "CALL Cinemas_GetAll()";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

            $userDao = new UserDAO();
        
            foreach($result as $row){
                $cinema = new Cinema();
                $cinema->setId($row['id']);
                $cinema->setName($row['name']);
                $cinema->setAddress($row['address']);
                $cinema->setOwner($userDao->getById($row['owner']));

                array_push($this->cinemasList, $cinema);
            }

            return $this->cinemasList;
        }

        public function add(Cinema $cinema)
        {
            
            $query = "CALL Cinemas_Add(?, ?, ?)";
            
            $parameters["name"] = $cinema->getName();
            $parameters["address"] = $cinema->getAddress();
            $parameters["owner"] = $cinema->getOwner()->getId();
            
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function deleteById($id)
        {
            $query = "CALL Cinemas_Delete(?)";

            $parameters["id"] = $id;
            
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

        public function update(Cinema $cinema){
            
            $query = "CALL Cinemas_Update(?, ?, ?)";

            $parameters["id"] = $cinema->getId();
            $parameters["name"] = $cinema->getName();
            $parameters["address"] = $cinema->getAddress();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

    }
?>