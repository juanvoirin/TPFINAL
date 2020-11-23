<?php

    namespace DAO;

    use Models\Ticket as Ticket;
    use DAO\ITicketDAO as ITicketDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use DAO\UserDAO as UserDAO;


    class TicketDAO implements ITicketDAO
    {

        private $connection;
        private $tableName = "tickets";


        public function getTicketById($idTicket){
            
            $ticket = NULL;

            $query = "CALL Tickets_GetById(?)";

            $parameters["idTicket"] = $idTicket;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            foreach($result as $row){
                $userDao = new UserDAO();
                $screeningDao = new ScreeningDAO();

                $ticket = new Ticket();
                $ticket->setId($row["id"]);
                $ticket->setUser($userDao->getById($row["idUser"]));
                $ticket->setScreening($screeningDao->getById($row["idScreening"]));
            }

            return $ticket;
        }

        public function getByUser($idUser)
        {
            $ticketsList = array();

            $query = "CALL Tickets_GetByUser(?)";

            $parameters["idUser"] = $idUser;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $userDao = new UserDAO();
            $screeningDao = new ScreeningDAO();
        
            foreach($result as $row){
                $ticket = new Ticket();
                $ticket->setId($row['id']);
                $ticket->setUser($userDao->getById($row['idUser']));
                $ticket->setScreening($screeningDao->getById($row['idScreening']));

                array_push($ticketsList, $ticket);
            }

            return $ticketsList;
        }

        public function add(Ticket $tickets)
        {
            
            $query = "CALL Tickets_Add(?, ?)";

            $parameters["idScreening"] = $tickets->getScreening()->getId();
            $parameters["idUser"] = $tickets->getUser()->getId();
            
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function getAvailability($idScreening)
        {

            $query = "CALL Tickets_GetAvailability(?)";

            $parameters["idScreening"] = $idScreening;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            foreach($result as $row){
                $quantity = $row["quantity"];
            }

            return $quantity;
        }

        public function getSoldByIdMovie($id_movie, $date_1, $date_2){

            $query = "CALL ScreeningsByIdMovieAndDate(?,?,?)";

            $parameters["id_movie"] = $id_movie;
            $parameters["date_1"] = $date_1;
            $parameters["date_2"] = $date_2;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,$parameters, QueryType::StoredProcedure);

            $price = 0;
            $id_screening = 0;
            $quantity = 0;
            $global = 0;

            if($result != NULL){
                foreach($result as $row){
                    $id_screening = $row["id_screening"];
                    $price = $row["price"];

                    $quantity = $this->getAvailability($id_screening);

                    if($quantity != NULL){
                        $parcial = $price * $quantity;
                        $global = $global + $parcial;
                    }

                }
            }
            return $global;
        }

        public function getSoldByIdCinema($id_cine, $date_1, $date_2){

            $query = "CALL ScreeningsByIdCineAndDate(?,?,?)";

            $parameters["id_cine"] = $id_cine;
            $parameters["date_1"] = $date_1;
            $parameters["date_2"] = $date_2;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,$parameters, QueryType::StoredProcedure);

            $price = 0;
            $id_screening = 0;
            $quantity = 0;
            $global = 0;

            if($result != NULL){
                foreach($result as $row){
                    $id_screening = $row["id_screening"];
                    $price = $row["price"];

                    $quantity = $this->getAvailability($id_screening);

                    if($quantity != NULL){
                        $parcial = $price * $quantity;
                        $global = $global + $parcial;
                    }

                }
            }
            return $global;
        }

        public function getListMoviesByOwner($idOwner)
        {
            $query = "CALL Tickets_GetListMoviesByOwner(?)";

            $parameters["idOwner"] = $idOwner;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            return $result;
        }

        public function getListCinemasByOwner($idOwner)
        {
            $query = "CALL Tickets_GetListCinemasByOwner(?)";

            $parameters["idOwner"] = $idOwner;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            return $result;
        }

        public function getListRoomsByCinema($idCinema)
        {
            $list = array();

            $query = "CALL Tickets_GetListRoomsByCinema(?)";

            $parameters["idCinema"] = $idCinema;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            foreach($result as $row){
                $array["room"] = $row["room"];
                $array["sold"] = $row["sold"];
                $array["remaining"] = ($row["capacity"] - $row["sold"]);

                array_push($list, $array);
            }

            return $list;
        }

    }
?>