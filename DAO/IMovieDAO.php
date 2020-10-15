<?php

    namespace DAO;

    interface IMovieDAO
    {
        function getByTitle($name);
        function getById($id);
        function add($id, $poster_path, $original_language, $genre_ids, $title, $overview, $release_date);
        function getAll();

    }

?>