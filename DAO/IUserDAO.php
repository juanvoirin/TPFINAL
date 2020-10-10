<?php

    namespace DAO;
    
    interface IUserDAO 
    {
        function getByEmail($email);
        function add($name, $email, $pass, $type);
    }

?>