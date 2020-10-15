<?php

    namespace DAO;

    use Models\Movie as Movie;
    use DAO\IMovieDAO as IMovieDAO;


    class MovieDAO implements IMovieDAO {

        private $moviesList = array();

        public function getByTitle($title) {

            $this->retrieveData();

            $movies = array();

            foreach ($this->moviesList as $row){
                if($title == $row->getTitle()){
                    $movie = new Movie();
                    $movie->setId($row->getId());
                    $movie->setPoster_path($row->getPoster_path());
                    $movie->setOriginal_language($row->getOriginal_language());
                    $movie->setGenre_ids($row->getGenre_ids());
                    $movie->setTitle($row->getTitle());
                    

                }
            }

        }

    }