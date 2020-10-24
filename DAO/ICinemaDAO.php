<?php

    namespace DAO;
    
    use Models\Cinema as Cinema;

    interface ICinemaDAO 
    {
        function getByName($name);
        function getByOwner($owner);
        function add(Cinema $cinema);
        function getAll();
    }

?>