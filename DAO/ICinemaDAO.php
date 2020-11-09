<?php

    namespace DAO;
    
    use Models\Cinema as Cinema;

    interface ICinemaDAO 
    {
        function getByOwnerId($owner);
        function getById($id);
        function add(Cinema $cinema);
        function getAll();
        function deleteById($id);
        function update(Cinema $cinema);
        
    }

?>