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
                    $movie->setGenres(1); //ARREGLAR CON NUEVO DAO Y NUEVA TABLA DE GENRES.
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
            $query = "CALL Movies_GetMoviesWithScreenings()";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

            $this->moviesList = array();

            foreach ($result as $row){
                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setPoster_path($row['poster_path']);
                $movie->setOriginal_language($row['original_language']);
                $movie->setGenres(1); //ARREGLAR CON NUEVO DAO Y NUEVA TABLA DE GENRES.
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

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $this->moviesList = array();

            foreach ($result as $row){
                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setPoster_path($row['poster_path']);
                $movie->setOriginal_language($row['original_language']);
                $movie->setGenres(1); //ARREGLAR CON NUEVO DAO Y NUEVA TABLA DE GENRES.
                $movie->setTitle($row['title']);
                $movie->setOverview($row['overview']);
                $movie->setRelease_date($row['release_date']);
                $movie->setRuntime($row['runtime']);

                array_push($this->moviesList, $movie);
            }
        
            return $this->moviesList;
        }

        public function getMovieWithScreeningByGenre($id_genre)
        {
            $query = "CALL Movies_GetMoviesWithScreeningsByGenre(?)";

            $parameters["id_genre"] = $id_genre;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $this->moviesList = array();

            foreach ($result as $row){
                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setPoster_path($row['poster_path']);
                $movie->setOriginal_language($row['original_language']);
                $movie->setGenres(1); //ARREGLAR CON NUEVO DAO Y NUEVA TABLA DE GENRES.
                $movie->setTitle($row['title']);
                $movie->setOverview($row['overview']);
                $movie->setRelease_date($row['release_date']);
                $movie->setRuntime($row['runtime']);

                array_push($this->moviesList, $movie);
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

            foreach ($result as $row){
                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setPoster_path($row['poster_path']);
                $movie->setOriginal_language($row['original_language']);
                $movie->setGenres(1); //ARREGLAR CON NUEVO DAO Y NUEVA TABLA DE GENRES.
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

            foreach ($result as $row){
                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setPoster_path($row['poster_path']);
                $movie->setOriginal_language($row['original_language']);
                $movie->setGenres(1); //ARREGLAR CON NUEVO DAO Y NUEVA TABLA DE GENRES.
                $movie->setTitle($row['title']);
                $movie->setOverview($row['overview']);
                $movie->setRelease_date($row['release_date']);
                $movie->setRuntime($row['runtime']);

                array_push($this->moviesList, $movie);
            }
        
            return $this->moviesList;
        } 

        public function getByGenreBD($genre)
        {   
            $query = "CALL Movies_GetByGenre(?)";

            $parameters["id_genre"] = $genre;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $this->moviesList = array();

            foreach ($result as $row){
                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setPoster_path($row['poster_path']);
                $movie->setOriginal_language($row['original_language']);
                $movie->setGenres(1); //ARREGLAR CON NUEVO DAO Y NUEVA TABLA DE GENRES.
                $movie->setTitle($row['title']);
                $movie->setOverview($row['overview']);
                $movie->setRelease_date($row['release_date']);
                $movie->setRuntime($row['runtime']);

                array_push($this->moviesList, $movie);
            }
        
            return $this->moviesList;
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
            
            $query = "CALL Movies_Add(?,?,?,?,?,?,?,?)";
 
            $parameters["id"] = $movie->getId();
            $parameters["title"] = $movie->getTitle();
            $parameters["poster_path"] = $movie->getPoster_path();
            $parameters["original_language"] = $movie->getOriginal_language();
            $parameters["overview"] = $movie->getOverview();
            $parameters["release_date"] = $movie->getRelease_date();
            $parameters["id_genre"] = 1; //ARREGLAR CON NUEVO DAO Y NUEVA TABLA DE GENRES.
            $parameters["runtime"] = $movie->getRuntime();

            $genreDao = new GenreDAO();

            

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
                $movieNew->setRuntime($this->getRuntimeAPI($movieNew->getId()));

                array_push($this->moviesList, $movieNew);
            }

            return $this->moviesList;
        }

        private function getRuntimeAPI($id){

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

            $genreDao = new GenreDAO();

            $movieNew = new Movie();
            $movieNew->setId($movie["id"]);
            $movieNew->setPoster_path($this->linkImage.$movie["poster_path"]);
            $movieNew->setOriginal_language($language->getByCode($movie["original_language"]));
            $movieNew->setGenres($genreDao->getGenreById($movie["genres"]));
            $movieNew->setTitle($movie["original_title"]);
            $movieNew->setOverview($movie["overview"]);
            $movieNew->setRelease_date($movie["release_date"]);
            $movieNew->setRuntime($this->getRuntimeAPI($movieNew->getId()));

            return $movieNew;
        }

    }

?>