<?php

    namespace DAO;

    interface IGenreDAO
    {
        function getByName($name);
        function add($id, $name);
        function getAll();

    }
    
?>