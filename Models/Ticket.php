<?php
    namespace Models;

    class Ticket {

        private $id;
        private $user;
        private $screening;

        public function setId($id){
            $this->id = $id;
        }

        public function getId(){
            return $this->id;
        }

        public function setUser(User $user){
            $this->user = $user;
        }

        public function getUser(){
            return $this->user;
        }

        public function setScreening(Screening $screening){
            $this->screening = $screening;
        }

        public function getScreening(){
            return $this->screening;
        }

    }

?>