<?php
    namespace Models;

    class Screening {

        private $id;
        private $date;
        private $time;
        private $runtime;
        private $sold;
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
            return $this->time;
        }

        public function setRuntime($runtime){
            $this->runtime = $runtime;
        }

        public function getRuntime(){
            return $this->runtime;
        }

        public function setIdRoom($idRoom){
            $this->idRoom = $idRoom;
        }

        public function getIdRoom(){
            return $this->idRoom;
        }

        public function setIdMovie($idMovie){
            $this->idMovie = $idMovie;
        }

        public function getIdMovie(){
            return $this->idMovie;
        }

        public function setSold($sold){
            $this->sold = $sold;
        }

        public function getSold(){
            return $this->sold;
        }

    }
?>
