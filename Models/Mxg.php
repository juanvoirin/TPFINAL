<?php

    namespace Models;

    class Mxg {

        private $id;
        private $id_movie;
        private $id_genre;

        public function setId($id){
            $this->id = $id;
        }

        public function getId(){
            return $this->id;
        }

        public function setId_movie($id_movie){
            $this->id_movie = $id_movie;
        }

        public function getId_movie(){
            return $this->id_movie;
        }

        public function setId_genre($id_genre){
            $this->id = $id_genre;
        }

        public function getId_genre(){
            return $this->id_genre;
        }
    }