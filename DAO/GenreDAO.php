<?php

    namespace DAO;

    use Models\Genre as Genre;
    use DAO\IGenreDAO as IGenreDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use DAO\MxgDAO as MxgDAO;



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

        public function add(Genre $genre, $idMovie){
            $query= "CALL Genre_Add(?,?)";

            $parameters['id'] = $genre->getId();
            $parameters['name'] = $genre->getName();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

            $movieXGenreDAO = new MxgDAO();

            $movieXGenreDAO->add($idMovie, $genre->getId());
        }

        public function getByIdMovie($idMovie){
            $MxgDAO = new MxgDAO();

            $idGenres = $MxgDAO->getIdGenresByIdMovie($idMovie);

            $this->genreList = array();

            foreach ($idGenres as $row){

                array_push($this->genreList, $this->getGenreByIdDB($row['idGenre']));
            }
            return $this->genreList;
        }

        public function getGenreByIdDB($idGenre){

            $query = "CALL Genre_GetById(?)";

            $parameters['id'] = $idGenre;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            foreach($result as $row){
                $genre = new Genre();
                $genre->setId($row['id']);
                $genre->setName($row['name']);
            }

            return $genre;
        }

    }

?>