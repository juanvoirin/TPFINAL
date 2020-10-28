<?php
    namespace Controllers;

    use DAO\CinemaDAO as CinemaDAO;
    use DAO\ScreeningDAO as ScreeningDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\MovieDAO as MovieDAO;

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

            $fecha_actual = strtotime(date("d-m-Y"));
            $fecha_entrada = strtotime($date);
                
            if($fecha_entrada > $fecha_actual)
            {
                $idCinema = $screeningDao->getCinemaByDateAndMovie($idMovie, $date);
            
                if($idCinema==NULL){
                    $cinemasList = $cinemaDao->getAll();
                    require_once(VIEWS_PATH."adm-form-screenings-cinemas.php");
                }else{
                    $this->showFormScreeningSelectRoom($idMovie, $date, $idCinema);
                }
            }else
            {
                $this->showFormScreening($idMovie);
            }
        }

        public function showFormScreeningSelectRoom($idMovie, $date, $idCinema){
            $roomDao = new RoomDAO();
            
            $roomList = $roomDao->getByCinemaId($idCinema);

            require_once(VIEWS_PATH."adm-form-screenings-rooms.php");
        }

        public function showFormScreeningTime($idMovie, $date, $idCinema, $idRoom){
            
            

            date_default_timezone_set("America/Argentina/Buenos_Aires");//ESTO MODIFICA EL TIMEZON QUE USA LA PAGINA

            $time = date("H:i:00",time());//ESTO OBTIENE LA HORA ACTUAL

            $timeList = array();

            array_push($timeList, $time);//ACA SE DEBERIAN AGREGAR LAS HORAS POSIBLES PARA AGREGAR LA FUNCION

            //POR EL MOMENTO DEJEMOS EL TIEMPO ASI, CUANDO TERMINES BASE DE DATOS ARREGLAMOS ESTO
            //ENTRE LOS DOS QUE NO ES NADA FACIL

            //Llamar funcion API p/ saber runtime. ESTO NOS VA A SERVIR PARA LAS RESTRICCIONES DE HORA ACA.

            require_once(VIEWS_PATH."adm-form-screenings-time.php");
        }

        public function addScreening($idMovie, $date, $idCinema, $idRoom, $time){

            //Llamar funcion API p/ saber runtime.

            $movieDao = new MovieDAO();
            $movie = $movieDao->getById($idMovie);
            $movieDao->add($movie);

            //Instanciar un objeto Screening que sera el que se enviara por parametro al add del DAO.
            //Llamar sentencia add ScreeningDAO
            
            $this->showScreeningsView();
        }
    }

?>