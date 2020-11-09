<?php

    namespace DAO;
    
    use Models\Ticket;
    
    interface ITicketDAO 
    {
        function add(Ticket $tickets);
        function getByUser($idUser);

    }

?>