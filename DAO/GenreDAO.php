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

        private function retrieveData(){
            $this->genreList = array();

            $jsonPath = $this->getJsonFilePath();

            $jsonContent = file_get_contents($jsonPath);

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            
            foreach ($arrayToDecode as $row) {
                $genre = new Genre();
                $genre->setId($row['id']);
                $genre->setName($row['name']);

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