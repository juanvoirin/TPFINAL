<?php

    namespace DAO;

    use Models\Movie as Movie;
    use DAO\IMovieDAO as IMovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\LanguagesDAO as LanguagesDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Genre as Genre;


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
                    $movie->setGenres($row->getGenres());
                    $movie->setTitle($row->getTitle());
                    $movie->setOverview($row->getOverview());
                    $movie->setRelease_date($row->getRelease_date());

                    array_push($movies, $movie);
                }
            }

            return $movies;
        }

        public function getMovieWithScreening()
        {
            $query = "CALL Movies_GetMoviesWithScreenings(?)";

            $date = date("Y-m-d");

            $parameters["dateNow"] = $date;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $this->moviesList = array();

            $genreDao = new GenreDAO();

            foreach ($result as $row){
                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setPoster_path($row['poster_path']);
                $movie->setOriginal_language($row['original_language']);
                $movie->setGenres($genreDao->getByIdMovie($movie->getId()));
                $movie->setTitle($row['title']);
                $movie->setOverview($row['overview']);
                $movie->setRelease_date($row['release_date']);
                $movie->setRuntime($row['runtime']);

                array_push($this->moviesList, $movie);
            }
        
            return $this->moviesList;
        }

        public function getMovieWithScreeningByOwner($idOwner)
        {
            $query = "CALL Movies_GetMoviesWithScreeningsByOwner(?)";

            $parameters["idOwner"] = $idOwner;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $this->moviesList = array();

            $genreDao = new GenreDAO();

            foreach ($result as $row){
                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setPoster_path($row['poster_path']);
                $movie->setOriginal_language($row['original_language']);
                $movie->setGenres($genreDao->getByIdMovie($movie->getId()));
                $movie->setTitle($row['title']);
                $movie->setOverview($row['overview']);
                $movie->setRelease_date($row['release_date']);
                $movie->setRuntime($row['runtime']);

                array_push($this->moviesList, $movie);
            }
        
            return $this->moviesList;
        }

        
        public function getMovieWithScreeningByDate($date)
        {
            $query = "CALL Movies_GetMoviesWithScreeningsByDate(?)";

            $parameters["date"] = $date;

            echo $date;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $this->moviesList = array();

            $genreDao = new GenreDAO();

            foreach ($result as $row){
                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setPoster_path($row['poster_path']);
                $movie->setOriginal_language($row['original_language']);
                $movie->setGenres($genreDao->getByIdMovie($movie->getId()));
                $movie->setTitle($row['title']);
                $movie->setOverview($row['overview']);
                $movie->setRelease_date($row['release_date']);
                $movie->setRuntime($row['runtime']);

                array_push($this->moviesList, $movie);
            }
        
            return $this->moviesList;
        }

        public function getMoviesByGenre($id_genre)
        {
            $mxgDAO = new MxgDAO();

            $result = $mxgDAO->getMoviesByIdgenre($id_genre);

            $resultList = array();
        
            if($result != NULL){
                foreach($result as $row){

                    $movie = $this->getById($row->getId_movie());
                    array_push($resultList, $movie);
                }
            }
            
            return $resultList; 
        }

        public function getMoviesWithScreeningsByIdGenre($id_genre){

            $this->moviesList = array();

            $result = $this->getMoviesByGenre($id_genre);

            $screeningDao = new ScreeningDAO();

            if($result != NULL){
                foreach($result as $row){
                    $screenings = $screeningDao->getByIdMovie($row->getId());
                    if($screenings != NULL){

                        array_push($this->moviesList, $row);

                    }
                }
            }

            return $this->moviesList;
        }

        public function getById($id)
        {   
            $query = "CALL Movies_GetById(?)";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $movie = NULL;

            $genreDao = new GenreDAO();

            foreach ($result as $row){
                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setPoster_path($row['poster_path']);
                $movie->setOriginal_language($row['original_language']);
                $movie->setGenres($genreDao->getByIdMovie($movie->getId()));
                $movie->setTitle($row['title']);
                $movie->setOverview($row['overview']);
                $movie->setRelease_date($row['release_date']);
                $movie->setRuntime($row['runtime']);
            }
            
            return $movie;
        }

        public function getByDateBD($date)
        {   
            $query = "CALL Movies_GetByDate(?)";

            $parameters["date"] = $date;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $this->moviesList = array();

            $genreDao = new GenreDAO();

            foreach ($result as $row){
                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setPoster_path($row['poster_path']);
                $movie->setOriginal_language($row['original_language']);
                $movie->setGenres($genreDao->getByIdMovie($movie->getId()));
                $movie->setTitle($row['title']);
                $movie->setOverview($row['overview']);
                $movie->setRelease_date($row['release_date']);
                $movie->setRuntime($row['runtime']);

                array_push($this->moviesList, $movie);
            }
        
            return $this->moviesList;
        } 

        /*public function getByGenreBD($genre)
        {   
            $query = "CALL Movies_GetByGenre(?)";

            $parameters["id_genre"] = $genre;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $this->moviesList = array();

            $genreDao = new GenreDAO();

            foreach ($result as $row){
                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setPoster_path($row['poster_path']);
                $movie->setOriginal_language($row['original_language']);
                $movie->setGenres($genreDao->getByIdMovie($movie->getId()));
                $movie->setTitle($row['title']);
                $movie->setOverview($row['overview']);
                $movie->setRelease_date($row['release_date']);
                $movie->setRuntime($row['runtime']);

                array_push($this->moviesList, $movie);
            }
        
            return $this->moviesList;
        } */

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
            
            $query = "CALL Movies_Add(?,?,?,?,?,?,?)";
 
            $parameters["id"] = $movie->getId();
            $parameters["title"] = $movie->getTitle();
            $parameters["poster_path"] = $movie->getPoster_path();
            $parameters["original_language"] = $movie->getOriginal_language();
            $parameters["overview"] = $movie->getOverview();
            $parameters["release_date"] = $movie->getRelease_date();
            $parameters["runtime"] = $movie->getRuntime();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

            $genreDao = new GenreDAO();
            foreach($movie->getGenres() as $genre){
                $genreById = $genreDao->getGenreByIdDB($genre->getId());
                if($genreById != NULL){
                    $mxgDao = new MxgDAO();
                    $mxgDao->add($movie->getId(), $genre->getId());
                    
                }else{
                    $genreDao->add($genre, $movie->getId());

                }
            }

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
                $movieNew->setRuntime($this->getRuntimeAPI($movieNew->getId()));

                array_push($this->moviesList, $movieNew);
            }

            return $this->moviesList;
        }

        public function getRuntimeAPI($id){

            $linkDetails = "https://api.themoviedb.org/3/movie/";

            $apiKey = "?api_key=1e9aba021ef977ce53b2219af44e6cd7";

            $APIarray = json_decode(file_get_contents($linkDetails.$id.$apiKey), true);

            $runtime = $APIarray["runtime"];

            return $runtime;

        }

        public function getByIdAPI($idMovie){

            $linkDetails = "https://api.themoviedb.org/3/movie/";

            $apiKey = "?api_key=1e9aba021ef977ce53b2219af44e6cd7";

            $movie = json_decode(file_get_contents($linkDetails.$idMovie.$apiKey), true);

            $language = new LanguagesDAO();

            $movieNew = new Movie();
            $movieNew->setId($movie["id"]);
            $movieNew->setPoster_path($this->linkImage.$movie["poster_path"]);
            $movieNew->setOriginal_language($language->getByCode($movie["original_language"]));
            
            $genresMovie = array();
            foreach($movie['genres'] as $genreAPI){
                $genre = new Genre();
                $genre->setName($genreAPI['name']);
                $genre->setId($genreAPI['id']);

                array_push($genresMovie, $genre);
            }

            $movieNew->setGenres($genresMovie);
            $movieNew->setTitle($movie["original_title"]);
            $movieNew->setOverview($movie["overview"]);
            $movieNew->setRelease_date($movie["release_date"]);
            $movieNew->setRuntime($this->getRuntimeAPI($movieNew->getId()));

            return $movieNew;
        }

    }

?>