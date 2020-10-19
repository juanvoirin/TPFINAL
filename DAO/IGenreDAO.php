<?php

    namespace DAO;

    interface IGenreDAO
    {
        function getGenreByName($name);
        function getAll();
        function getGenreById($id);

    }
    
?>