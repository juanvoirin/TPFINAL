<?php

    namespace DAO;
    
    use Models\Cinema as Cinema;

    interface ICinemaDAO 
    {
        function getByOwnerId($owner);
        function add(Cinema $cinema);
        function getAll();
    }

?>