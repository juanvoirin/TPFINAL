<?php

    namespace DAO;

    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use DAO\UserDAO as UserDAO;
    use Models\Screening as Screening;


    class ScreeningDAO //implements IScreeningDAO CREAR Y ACTUALIZAR TODAS LAS INTERFACES
    {

        private $connection;
        private $tableName = "screenings";


        public function getCinemaByDateAndMovie($idMovie, $date){

            //HACER LA SENTENCIA Y EN EL WHERE PONER LA DOBLE CONDICION.
            //TAMBIEN HACER QUE SI NO HAY NINGUN CINE QUE CUMPLA LOS DOS REQUISITOS QUE DEVUELVA NULL

            return NULL; //Este return es para probar, despues cambiarlo
        }

        public function getById($id)
        {

            //HACER
        }

        public function getByRoom($idRoom){

            //CREAR UNA SENTENCIA QUE TRAIGA TODAS LAS FUNCIO

        }

        public function getAll()
        {
            //HACER
        }

        public function add()
        {
            
            //HACER
        }

        public function deleteById($id)
        {
            //HACER

        }

    }
?>