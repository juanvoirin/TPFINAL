<?php
    namespace Models;

    class Screening {

        private $id;
        private $date;
        private $time;
        private $idRoom;
        private $idMovie;

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
            return $this->date;
        }

        public function setId_room($idRoom){
            $this->idRoom = $idRoom;
        }

        public function getIdRoom(){
            return $this->idRoom;
        }

        public function setId_movie($idMovie){
            $this->idMovie = $idMovie;
        }

        public function getIdMovie(){
            return $this->idMovie;
        }

    }
?>
