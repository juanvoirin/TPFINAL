<?php

    namespace DAO;

    use Models\Genre as Genre;
    use DAO\IGenreDAO as IGenreDAO;


    class GenreDAO implements IGenreDAO {

        private $genreList = array();

        public function getByName($name)
        {
            $this->retrieveData();

            $genres = array();

            foreach ($this->genreList as $row){
                if($name == $row->getName()){
                    $genre = new Genre();
                    $genre->setId($row->getId());
                    $genre->setName($row->getName());

                    array_push($genres, $genre);
                }
            }
            return $genre;
        }

        public function getAll(){

            $this->retrieveData();
            return $this->genreList;
        }

        public function add ($id, $name){
            $genre = new Genre();
            $genre->setId($id);
            $genre->setName($name);

            $this->retrieveData();
            array_push($this->genreList, $genre);
            $this->saveData();
        }

        public function getGenresAPI(){
            $urlAPI = "https://api.themoviedb.org/3/genre/movie/list?api_key=1e9aba021ef977ce53b2219af44e6cd7&language=en-US";
            $APIarray = json_decode(file_get_contents($urlAPI), true);

            $this->genreList = array();

            foreach($APIarray["genres"] as $genre){
                $genreNew = new Genre();
                $genreNew->setId($genre["id"]);
                $genreNew->setName($genre["name"]);

                array_push($this->genreList, $genre);
            }
            return $this->genreList;
        }

        private function retrieveData(){
            $this->genreList = array();

            $jsonPath = $this->getJsonFilePath();

            $jsonContent = file_get_contents($jsonPath);

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            
            foreach ($arrayToDecode["genres"] as $row) {
                $genre = new Genre();
                $genre->setId($row["id"]);
                $genre->setName($row["name"]);

                array_push($this->genreList, $genre);
            }

        }

        private function saveData(){
            $arrayToDecode = array();

            $jsonPath = $this->getJsonFilePath();

            foreach ($this->genreList as $genre){
                $valueArray['id'] = $genre->getId();
                $valueArray['name'] = $genre->getName();

                array_push($arrayToDecode, $valueArray);
            }
            $jsonContent = json_encode($arrayToDecode, JSON_PRETTY_PRINT);
            file_put_contents($jsonPath, $jsonContent);
        }

        private function getJsonFilePath(){

            $initialPath = "Data/genres.json";
            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }

            return $jsonFilePath;
        }




    }