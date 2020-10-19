<?php

    namespace DAO;

    use Models\Movie as Movie;
    use DAO\IMovieDAO as IMovieDAO;


    class MovieDAO implements IMovieDAO {

        private $moviesList = array();

        private $linkImage = "https://image.tmdb.org/t/p/w500";

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

        public function getByDate($release_date){
            $urlAPI = "https://api.themoviedb.org/3/movie/now_playing?api_key=1e9aba021ef977ce53b2219af44e6cd7&language=en-US&page=1";
            
            $APIarray = json_decode(file_get_contents($urlAPI), true);
            
            $this->moviesList = array();

            foreach($APIarray["results"] as $movie){
                
                if($release_date == $movie["release_date"]){
                    $movieNew = new Movie();
                    $movieNew->setId($movie["id"]);
                    $movieNew->setPoster_path($this->linkImage.$movie["poster_path"]);
                    $movieNew->setOriginal_language($movie["original_language"]);
                    $movieNew->setGenre_ids($movie["genre_ids"]);
                    $movieNew->setTitle($movie["original_title"]);
                    $movieNew->setOverview($movie["overview"]);
                    $movieNew->setRelease_date($movie["release_date"]);
                }
                

                array_push($this->moviesList, $movieNew);
            }

            return $this->moviesList;
        }
        

        public function getByGenreIds($genre_ids){
            $urlAPI = "https://api.themoviedb.org/3/movie/now_playing?api_key=1e9aba021ef977ce53b2219af44e6cd7&language=en-US&page=1";
            
            $APIarray = json_decode(file_get_contents($urlAPI), true);
            
            $this->moviesList = array();

            foreach($APIarray["results"] as $movie){
                
                if(array_key_exists($genre_ids,$movie["genre_ids"])){
                    $movieNew = new Movie();
                    $movieNew->setId($movie["id"]);
                    $movieNew->setPoster_path($this->linkImage.$movie["poster_path"]);
                    $movieNew->setOriginal_language($movie["original_language"]);
                    $movieNew->setGenre_ids($movie["genre_ids"]);
                    $movieNew->setTitle($movie["original_title"]);
                    $movieNew->setOverview($movie["overview"]);
                    $movieNew->setRelease_date($movie["release_date"]);
                }
                

                array_push($this->moviesList, $movieNew);
            }

            return $this->moviesList;

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

        private function addMoviesAPI(){

            $urlAPI = "https://api.themoviedb.org/3/movie/now_playing?api_key=1e9aba021ef977ce53b2219af44e6cd7&language=en-US&page=1";
            $APIarray = json_decode(file_get_contents($urlAPI), true);
            for($i=0; $i<count($APIarray); $i++ ){
               $this->add($APIarray[$i]["id"],$APIarray[$i]["poster_path"],$APIarray[$i]["original_language"],$APIarray[$i]["genre_ids"], $APIarray[$i]["title"],$APIarray[$i]["overview"], $APIarray[$i]["release_date"]);
            }
        }

        public function getMoviesAPI(){
            $urlAPI = "https://api.themoviedb.org/3/movie/now_playing?api_key=1e9aba021ef977ce53b2219af44e6cd7&language=en-US&page=1";
            
            $APIarray = json_decode(file_get_contents($urlAPI), true);
            
            $this->moviesList = array();

            foreach($APIarray["results"] as $movie){
                $movieNew = new Movie();
                $movieNew->setId($movie["id"]);
                $movieNew->setPoster_path($this->linkImage.$movie["poster_path"]);
                $movieNew->setOriginal_language($movie["original_language"]);
                $movieNew->setGenre_ids($movie["genre_ids"]);
                $movieNew->setTitle($movie["original_title"]);
                $movieNew->setOverview($movie["overview"]);
                $movieNew->setRelease_date($movie["release_date"]);

                array_push($this->moviesList, $movieNew);
            }

            return $this->moviesList;
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