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
                    
                    $movie->setOverview($row->getOverview());
                    $movie->setRelease_date($row->getRelease_date());

                    array_push($movies, $movie);
                }
            }
            return $movies;

        }

        public function getById($id)
        {
            
            $this->retrieveData();

            $movies = array();

            foreach ($this->moviesList as $row){
                if($id == $row->getId()){
                    $movie = new Movie();
                    $movie->setId($row->getId());
                    $movie->setPoster_path($row->getPoster_path());
                    $movie->setOriginal_language($row->getOriginal_language());
                    $movie->setGenre_ids($row->getGenre_ids());
                    $movie->setTitle($row->getTitle());
                    $movie->setOverview($row->getOverview());
                    $movie->setRelease_date($row->getRelease_date());

                    array_push($movies, $movie);
                }
            }
            return $movies;

        }

        public function getAll(){

            $this->retrieveData();

            return $this->moviesList;
        }

        public function add($id, $poster_path, $original_language, $genre_ids, $title, $overview, $release_date){
            
            $movie = new Movie();
            $movie->setId($id);
            $movie->setPoster_path($poster_path);
            $movie->setOriginal_language($original_language);
            $movie->setGenre_ids($genre_ids);
            $movie->setTitle($title);
            $movie->setOverview($overview);
            $movie->setRelease_date($release_date);

            $this->retrieveData();

            array_push($movies, $movie);

            $this->saveData();
        }

        private function retrieveData(){
            $this->movieList = array();

            $jsonPath = $this->getJsonFilePath();

            $jsonContent = file_get_contents($jsonPath);

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $row) {
                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setPoster_path($row['poster_path']);
                $movie->setOriginal_language($row['original_language']);
                $movie->setGenre_ids($row['genre_ids']);
                $movie->setTitle($row['title']);
                $movie->setOverview($row['overview']);
                $movie->setRelease_date($row['release_date']);

                array_push($this->moviesList, $movie);

            }
        }

        private function saveData(){

            $arrayToEncode = array();

            $jsonPath = $this->getJsonFilePath();

            foreach ($this->moviesList as $movie){
                $valueArray['id'] = $movie->getId();
                $valueArray['poster_path'] = $movie->getPoster_path();
                $valueArray['original_language'] = $movie->getOriginal_language();
                $valueArray['genre_ids'] = $movie->getOriginal_language();
                $valueArray['title'] = $movie->getTitle();
                $valueArray['overview'] = $movie->getOverview();
                $valueArray['release_date'] = $movie->getRelease_date();

                array_push($arrayToEncode, $valueArray);

            }
            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($jsonPath, $jsonContent);

        }

        private function getJsonFilePath(){

            $initialPath = 'Data/movies.json';
            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }
            return $jsonFilePath;
        }

    }

    ?>