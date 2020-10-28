<?php
    namespace Models;

    class Movie {

        private $id;
        private $poster_path;
        private $original_language;
        private $genres;
        private $title;
        private $overview;
        private $release_date;
        private $runtime;

        public function setId($id) {
            $this->id = $id;
        }

        public function getId() {
            return $this->id;
        }

        public function setPoster_path($poster_path) {
            $this->poster_path = $poster_path;
        }

        public function getPoster_path () {
            return $this->poster_path;
        }

        public function setOriginal_language($original_language) {
            $this->original_language = $original_language;
        }

        public function getOriginal_language () {
            return $this->original_language;
        }
        
        public function setGenres($genres){
            $this->genres = $genres;
        }

        public function getGenres(){
            return $this->genres;
        }

        public function getGenresString(){
            $result = "";
            foreach($this->genres as $genre){
                if($result == ""){
                    $result = $genre->getName();
                }else{
                    $result = $result.", ".$genre->getName();
                }
            }
            return $result;
        }

        public function genreExist($id){
            $result = false;
            foreach($this->genres as $genre){
                if($genre->getId() == $id){
                    $result = true;
                }
            }
            return $result;
        }

        public function setTitle($title){
            $this->title = $title;
        }

        public function getTitle (){
            return $this->title;
        }

        public function setOverview ($overview){
            $this->overview = $overview;
        }

        public function getOverview (){
            return $this->overview;
        }

        public function setRelease_date($release_date){
            $this->release_date = $release_date;
        }

        public function getRelease_date(){
            return $this->release_date;
        }

        public function setRuntime($runtime){
            $this->runtime = $runtime;
        }

        public function getRuntime(){
            return $this->runtime;
        }
        
    }
?>