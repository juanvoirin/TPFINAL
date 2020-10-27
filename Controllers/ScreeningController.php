<?php
    namespace Controllers;


    class HomeController
    {

        public function index()
        {
            require_once(VIEWS_PATH."home.php");
        }

        public function showScreeningsView(){
            
            //Listar Funciones


            require_once(VIEWS_PATH."home.php");
        }

        public function showFormScreening($idMovie){

            //A formulario fecha

            require_once(VIEWS_PATH."home.php");
        }

        public function showScreeningSelectCinema($idMovie, $date){

            //Restricciones cines
            //A formulario select cines
        }

        public function showScreeningSelectRoom($idCinema, $idMovie, $date){

            //Mostrar salas de cine
            //A formulario select rooms and hour

        }

        public function addScreening($idCinema, $idMovie, $date, $time, $idRoom){

            //Llamar funcion API p/ saber runtime
            //Llamar sentencia add DAO
            //Llamar vista all screenings

        }
    }

?>