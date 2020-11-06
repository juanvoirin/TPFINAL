<?php

    namespace DAO;

    use Models\Screening as Screening;

    interface IScreeningDAO
    {
        function getCinemaByDateAndMovie($idMovie, $date);
        function getById($id);
        function getByRoom($idRoom);
        function getAll();
        function add(Screening $screening);
        function deleteById($id);
    }
?>