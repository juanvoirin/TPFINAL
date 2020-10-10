<?php

    namespace DAO;
    
    interface ICinemaDAO 
    {
        function getByName($name);
        function getByOwner($owner);
        function add($name, $capacity, $address, $price, $owner);
        function getAll();
    }

?>