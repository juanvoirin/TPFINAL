<?php
    namespace Models;

    use Models\Room;
    use Models\Movie;

    class Screening {

        private $id;
        private $date;
        private $time;
        private $runtime;
        private $sold;
        private $room;
        private $movie;

        public function setId($id){
            $this->id = $id;
        }

        public function getId(){
            return $this->id;
        }

        public function setDate($date){
            $this->date = $date;
        }

        public function getDate(){
            return $this->date;
        }

        public function setTime($time){
            $this->time = $time;
        }

        public function getTime(){
            return $this->time;
        }

        public function setRuntime($runtime){
            $this->runtime = $runtime;
        }

        public function getRuntime(){
            return $this->runtime;
        }

        public function setRoom(Room $room){
            $this->room = $room;
        }

        public function getRoom(){
            return $this->room;
        }

        public function setMovie(Movie $movie){
            $this->movie = $movie;
        }

        public function getMovie(){
            return $this->movie;
        }

        public function setSold($sold){
            $this->sold = $sold;
        }

        public function getSold(){
            return $this->sold;
        }

    }
?>
