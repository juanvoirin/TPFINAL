<?php

    namespace DAO;

    use Models\Genre as Genre;
    use DAO\IGenreDAO as IGenreDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;



    class GenreDAO implements IGenreDAO {

        private $genreList = array();

        public function getGenreByName($name){
            $this->getGenresAPI();
            $genres = array();

            foreach ($this->genreList as $row){
                if($row->getName() == $name){
                    $genre = new Genre();
                    $genre->setId($row->getId());
                    $genre->setName($row->getName());

                    array_push($genres, $genre);
                }
            }
            return $genres;
        }

        public function getAll(){

            return $this->getGenresAPI();
        }

        public function getGenreById($id){
            $this->getGenresAPI();
            $genres = array();

            foreach($this->genreList as $row){
                if($row->getId() == $id[0] or (isset($id[1]) && $row->getId() == $id[1]) or (isset($id[2]) && $row->getId() == $id[2])){
                    $genre = new Genre();
                    $genre->setId($row->getId());
                    $genre->setName($row->getName());

                    array_push($genres, $genre);
                }
            }
            return $genres;
        }

        private function getGenresAPI(){
            $urlAPI = "https://api.themoviedb.org/3/genre/movie/list?api_key=1e9aba021ef977ce53b2219af44e6cd7&language=en-US";
            $APIarray = json_decode(file_get_contents($urlAPI), true);

            $this->genreList = array();

            foreach($APIarray["genres"] as $genre){
                $genreNew = new Genre();
                $genreNew->setId($genre["id"]);
                $genreNew->setName($genre["name"]);

                array_push($this->genreList, $genreNew);
            }
            return $this->genreList;
        }

        public function add(Genre $genre){
            $query= "CALL Genre_Add (?,?)";

            $parameters[`id`] = $genre->getId();
            $parameters[`name`] = $genre->getName();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function getByIdMovie($id){
            $query = "CALL Genre_GetByIdMovie";

            $parameters[`id_movie`] = $id;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $this->genreList = array();

            foreach ($result as $row){
                $genre = new Genre();
                $genre->setId($row[`id`]);
                $genre->setName($row[`name`]);

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