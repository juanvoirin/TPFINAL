<?php
    namespace Models;

    class Ticket {

        private $id;
        private $idUser;
        private$idScreening;
        //elimino date por que ya trae la fecha desde la funcion.

        public function setId($id){
            $this->id = $id;
        }

        public function getId(){
            return $this->id;
        }

        public function setIdUser($idUser){
            $this->idUser = $idUser;
        }

        public function getIdUser(){
            return $this->idUser;
        }

        public function setIdScreening($idScreening){
            $this->idScreening = $idScreening;
        }

        public function getIdScreening(){
            return $this->idScreening;
        }

    }

?>