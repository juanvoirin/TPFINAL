<?php

    namespace DAO;

    use Models\Movie as Movie;

    interface IMovieDAO
    {
        function getByTitle($name);
        function getById($id);
        function add(Movie $movie);
        function getAllAPI();

    }

?>