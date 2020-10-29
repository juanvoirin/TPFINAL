<?php

    namespace DAO;

    use Models\Movie as Movie;
    use DAO\IMovieDAO as IMovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\LanguagesDAO as LanguagesDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;


    class MovieDAO implements IMovieDAO {

        private $moviesList = array();

        private $linkImage = "https://image.tmdb.org/t/p/w500";

        public function getByTitle($title) {

            $this->getMoviesAPI();

            $movies = array();

            foreach ($this->moviesList as $row){
                if($title == $row->getTitle()){
                    $movie = new Movie();
                    $movie->setId($row->getId());
                    $movie->setPoster_path($row->getPoster_path());
                    $movie->setOriginal_language($row->getOriginal_language());
                    $movie->setGenres($row->getGenre_ids());
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
            $this->getMoviesAPI();

            $movie = new Movie();

            foreach ($this->moviesList as $row){
                if($id == $row->getId()){
                    $movie->setId($row->getId());
                    $movie->setPoster_path($row->getPoster_path());
                    $movie->setOriginal_language($row->getOriginal_language());
                    $movie->setGenres($row->getGenre_ids());
                    $movie->setTitle($row->getTitle());
                    $movie->setOverview($row->getOverview());
                    $movie->setRelease_date($row->getRelease_date());
                }
            }
            return $movie;
        }

        public function getByDate($release_date){
            $this->getMoviesAPI();

            $return = array();

            foreach($this->moviesList as $movie){
                if($release_date == $movie->getRelease_date()){
                    
                    array_push($return, $movie);
                }
            }
            return $return;
        }
        

        public function getByGenreIds($genre){
            
            $this->getMoviesAPI();

            $return = array();
            foreach($this->moviesList as $movie){
                if($movie->genreExist($genre)){

                    array_push($return, $movie);
                }
            }
            return $return;
        }

        public function getAllAPI(){

            return $this->getMoviesAPI();
        }

        public function add(Movie $movie){
            
            $query = "CALL Movies_Add(?,?,?,?,?,?,?)"; // FALTA HACER FUNCION EN EL MOVIEPASS

            $parameters["id"] = $movie->getId();
            $parameters["title"] = $movie->getTitle();
            $parameters["poster_path"] = $movie->getPoster_path();
            $parameters["original_language"] = $movie->getOriginal_language();
            $parameters["overview"] = $movie->getOverview();
            $parameters["release_date"] = $movie->getRelease_date();
            $parameters["id_genre"] = $movie->getGenres();
            $parameters["runtime"] = $movie->getRuntime();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

        private function getMoviesAPI(){
            $urlAPI = "https://api.themoviedb.org/3/movie/now_playing?api_key=1e9aba021ef977ce53b2219af44e6cd7&language=en-US&page=1";
            
            $APIarray = json_decode(file_get_contents($urlAPI), true);
            
            $this->moviesList = array();

            $language = new LanguagesDAO();

            $genre = new GenreDAO();

            foreach($APIarray["results"] as $movie){
                $movieNew = new Movie();
                $movieNew->setId($movie["id"]);
                $movieNew->setPoster_path($this->linkImage.$movie["poster_path"]);
                $movieNew->setOriginal_language($language->getByCode($movie["original_language"]));
                $movieNew->setGenres($genre->getGenreById($movie["genre_ids"]));
                $movieNew->setTitle($movie["original_title"]);
                $movieNew->setOverview($movie["overview"]);
                $movieNew->setRelease_date($movie["release_date"]);
                //$movieNew->setRuntime($movie["runtime"]); FALTA ARREGLAR

                array_push($this->moviesList, $movieNew);
            }

            return $this->moviesList;
        }

    }

?>