<?php

    namespace DAO;

    use Models\User as User;
    
    interface IUserDAO 
    {
        function getByEmail($email);
        function add(User $user);
        function getById($id);
        function getAll();
        function deletebyEmail($email);
        

    }

?>