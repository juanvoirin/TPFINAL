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

    }
?>