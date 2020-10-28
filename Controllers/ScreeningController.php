<?php
    namespace Controllers;

    use DAO\CinemaDAO as CinemaDAO;
    use DAO\ScreeningDAO as ScreeningDAO;
    use DAO\RoomDAO as RoomDAO;

    class ScreeningController
    {

        public function index()
        {
            require_once(VIEWS_PATH."home.php");
        }

        public function showScreeningsView(){
            
            //Listar Funciones


            require_once(VIEWS_PATH."home.php");//No tengo la vista por eso redirige al HOME
        }

        public function showFormScreening($idMovie){

            require_once(VIEWS_PATH."adm-form-screenings-date.php");
        }

        public function showFormScreeningSelectCinema($idMovie, $date){
            $screeningDao = new ScreeningDAO();
            $cinemaDao = new CinemaDAO();

            $idCinema = $screeningDao->getCinemaByDateAndMovie($idMovie, $date);
            
            if($idCinema==NULL){
                $cinemasList = $cinemaDao->getAll();
                require_once(VIEWS_PATH."adm-form-screenings-cinemas.php");
            }else{
                $this->showFormScreeningSelectRoom($idMovie, $date, $idCinema);
            }
        }

        public function showFormScreeningSelectRoom($idMovie, $date, $idCinema){
            $roomDao = new RoomDAO();
            
            $roomList = $roomDao->getByCinemaId($idCinema);

            require_once(VIEWS_PATH."adm-form-screenings-rooms.php");
        }

        public function showFormScreeningTime($idMovie, $date, $idCinema, $idRoom){
            
            

            require_once(VIEWS_PATH."adm-form-screenings-time.php");
        }

        public function addScreening($idCinema, $idMovie, $date, $time, $idRoom){

            //Llamar funcion API p/ saber runtime
            //Llamar sentencia add DAO
            //Llamar vista all screenings

        }
    }

?>