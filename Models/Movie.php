<?php
    namespace Models;

    class Movie {

        private $id;
        private $poster_path;
        private $original_language;
        private $genre_ids;
        private $title;
        private $overview;
        private $release_date;

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
        
        public function setGenre_ids($genre_ids){
            $this->genre_ids = $genre_ids;
        }

        public function getGenre_ids () {
            return $this->genre_ids;
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
        
    }
?>