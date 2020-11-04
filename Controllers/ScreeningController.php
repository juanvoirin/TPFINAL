<?php
    namespace Controllers;

    use DAO\CinemaDAO as CinemaDAO;
    use DAO\ScreeningDAO as ScreeningDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\MovieDAO as MovieDAO;
    use Models\Screening as Screening;
    use DAO\GenreDAO as GenreDAO;
    use DAO\UserDAO as UserDAO;
    use DateInterval;
    use DatePeriod;
    use DateTime;

class ScreeningController
    {

        public function index()
        {
            $genreDao = new GenreDAO();

            $genreList = array();
            $genreList = $genreDao->getAll();
            
            $movieDao = new MovieDAO();

            $movieList = array();
            $movieList = $movieDao->getMovieWithScreening();

            require_once(VIEWS_PATH."home.php");
        }

        public function showListView(){
            
            $screeningDao = new ScreeningDAO();
            $screeningList = $screeningDao->getAll();


            require_once(VIEWS_PATH."user-list-screenings.php");
        }

        public function showListScreeningsIdMovie($idMovie){

            $screeningDao = new ScreeningDAO();
            $screeningList = $screeningDao->getByIdMovie($idMovie);

            require_once(VIEWS_PATH."user-list-screenings.php");

        }


        public function showFormScreening($idMovie){

            $movieDao = new MovieDAO();

            $movie = $movieDao->getByIdAPI($idMovie);

            require_once(VIEWS_PATH."adm-form-screenings-date.php");
        }

        public function showFormScreeningSelectCinema($idMovie, $date){

            $screeningDao = new ScreeningDAO();
            $cinemaDao = new CinemaDAO();
            $movieDao = new MovieDAO();
            $userDao = new UserDAO();

            $movie = $movieDao->getByIdAPI($idMovie);

            $fecha_actual = strtotime(date("d-m-Y"));
            $fecha_entrada = strtotime($date);
                
            if($fecha_entrada > $fecha_actual)
            {
                $idCinema = $screeningDao->getCinemaByDateAndMovie($idMovie, $date);
            
                if($idCinema==NULL){
                    $cinemasList = $cinemaDao->getByOwnerId($userDao->getByEmail($_SESSION["loggedUser"])->getId());
                    require_once(VIEWS_PATH."adm-form-screenings-cinemas.php");
                }else{
                    $this->showFormScreeningSelectRoom($idMovie, $date, $idCinema->getRoom()->getCinema()->getId());
                }
            }else
            {
                $this->showFormScreening($idMovie);
            }
        }

        public function showFormScreeningSelectRoom($idMovie, $date, $idCinema){
            $movieDao = new MovieDAO();

            $movie = $movieDao->getByIdAPI($idMovie);

            $cinemaDao = new CinemaDAO();

            $cinema = $cinemaDao->getById($idCinema);
            
            $roomDao = new RoomDAO();
            
            $roomList = $roomDao->getByCinemaId($idCinema);

            require_once(VIEWS_PATH."adm-form-screenings-rooms.php");
        }

        public function showFormScreeningTime($idMovie, $date, $idCinema, $idRoom){
            
            $movieDao = new MovieDAO();

            $movie = $movieDao->getByIdAPI($idMovie);

            $cinemaDao = new CinemaDAO();

            $cinema = $cinemaDao->getById($idCinema);
            
            $roomDao = new RoomDAO();

            $room = $roomDao->getById($idRoom);

            date_default_timezone_set("America/Argentina/Buenos_Aires");//ESTO MODIFICA EL TIMEZON QUE USA LA PAGINA

            $star = '14:00';
            $finish = '23:00';

            $hourInicio = new DateTime($star);
            $hourFinal = new DateTime($finish);
            $hourFinal = $hourFinal->modify('+15 minutes');

            $rangoHours = new DatePeriod($hourInicio, new DateInterval('PT15M'), $hourFinal);

            $timeList = array();

            $screeningDAO = new ScreeningDAO();
            
            $screeningBefore = new Screening();
            $screeningBefore = $screeningDAO->getFinishHourScreening($idRoom, $date); // TRAE LA FUNCION CON LA HORA DE INICIO MAXIMA DE ESE DIA Y SALA

            

            if($screeningBefore != NULL){
                $runtime = $screeningBefore->getRuntime() + 15;
                $hours = floor($runtime / 60);
                $minutes = floor($runtime - ($hours * 60));
            
                $hourReferences = new DateTime($screeningBefore->getTime());
                $hourReferences->modify('+'.$hours." hour");
                $hourReferences->modify(('+'.$minutes." minutes"));
                
                if($hourReferences > $hourInicio){
                    $rangoHours = new DatePeriod($hourReferences, new DateInterval('PT15M'), $hourFinal);
                    foreach($rangoHours as $hour){
               
                        array_push($timeList, $hour->format("H:i"));
                    }
                }

            }else{
                foreach($rangoHours as $hour){
               
                    array_push($timeList, $hour->format("H:i"));
                }
            }

            /*foreach($rangoHours as $hour){
               
                array_push($timeList, $hour->format("H:i"));
            } // MIENTRAS TANTO SE EJECUTA ESTO QUE DEVUELVE UN ARREGLO DE HORARIOS CON INTERVALOS DE 15 MINUTOS DESDE LAS 14 A LAS 23. YA PROBADO
            */

            require_once(VIEWS_PATH."adm-form-screenings-time.php");
        }

        public function addScreening($idMovie, $date, $idCinema, $idRoom, $time){

            //Llamar funcion API p/ saber runtime.

            $movieDao = new MovieDAO();
            $movie = $movieDao->getById($idMovie);
            if($movie == NULL){
                $movie = $movieDao->getByIdAPI($idMovie);
                $movieDao->add($movie);
            }
            
            $cinemaDao = new CinemaDAO();
            $cinema = $cinemaDao->getById($idCinema);

            $roomDao = new RoomDAO();
            $room = $roomDao->getById($idRoom);

            $screeningDao = new ScreeningDAO();

            $screening = new Screening();
            $screening->setDate($date);
            $screening->setTime($time);
            $screening->setRuntime($movie->getRuntime());
            $screening->setRoom($room);
            $screening->setMovie($movie);

            $screeningDao->add($screening);

            $this->showListView();
        }

        public function deleteScreening($id){
            $this->screeningDao = new ScreeningDAO();
            $this->screeningDao->deleteById($id);

            $this->showListView();
        }
    }

?>