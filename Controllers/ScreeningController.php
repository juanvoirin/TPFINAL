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
    use \Exception as Exception;

class ScreeningController
    {

        public function index($message = "")
        {
            try{
                $genreDao = new GenreDAO();

                $genreList = array();
                $genreList = $genreDao->getAll();
                
                $movieDao = new MovieDAO();

                $movieList = array();
                $movieList = $movieDao->getMovieWithScreening();

            }catch(Exception $e){
                $message = "No fue posible establecer una conexion con la Base de Datos.";
            }

            require_once(VIEWS_PATH."home.php");
        }

        public function showListView($message = ""){
            
            try{
                $screeningDao = new ScreeningDAO();

                $screeningList = array();
                $screeningList = $screeningDao->getAll();

            }catch(Exception $e){
                $message = "No fue posible establecer una conexion con la Base de Datos.";
            }

            require_once(VIEWS_PATH."user-list-screenings.php");
        }

        public function showListScreeningsIdMovie($idMovie){

            try{
                $screeningDao = new ScreeningDAO();
                $screeningList = $screeningDao->getByIdMovie($idMovie);

                require_once(VIEWS_PATH."user-list-screenings.php");

            }catch(Exception $e){
                $this->showListView("No fue posible establecer una conexion con la Base de Datos.");
            }
        }


        public function showFormScreening($idMovie, $message = ""){

            try{
                $movieDao = new MovieDAO();

                $movie = $movieDao->getByIdAPI($idMovie);

                $userDao = new UserDAO();
                $idOwner = $userDao->getByEmail($_SESSION["loggedUser"])->getId();

                $cinemaDao = new CinemaDAO();
                $arrayCinemas = $cinemaDao->getByOwnerId($idOwner);

                $return = FALSE;

                if(count($arrayCinemas)>0){
                    $roomDao = new RoomDAO();
                    foreach($arrayCinemas as $cinema){
                        if(count($roomDao->getByCinemaId($cinema->getId())) > 0){
                            $return = TRUE;
                        }
                    }
                    if(!$return){
                        $message = "No hay salas disponibles para crear una funcion.";
                    }
                }else{
                    $message = "No hay cines disponibles para crear una funcion.";
                }

                if($return){
                    require_once(VIEWS_PATH."adm-form-screenings-date.php");
                }else{
                    $this->index($message);
                }

            }catch(Exception $e){
                $this->showListView("No fue posible establecer una conexion con la Base de Datos.");
            }
        }

        public function showFormScreeningSelectCinema($idMovie, $date){

            try{    
                $screeningDao = new ScreeningDAO();
                $cinemaDao = new CinemaDAO();
                $movieDao = new MovieDAO();
                $userDao = new UserDAO();

                $movie = $movieDao->getByIdAPI($idMovie);

                $fecha_actual = strtotime(date("d-m-Y"));
                $fecha_entrada = strtotime($date);
                    
                if($fecha_entrada > $fecha_actual)
                {
                    $screeningInDate = $screeningDao->getCinemaByDateAndMovie($idMovie, $date);
                
                    if($screeningInDate==NULL){
                        $cinemasList = $cinemaDao->getByOwnerId($userDao->getByEmail($_SESSION["loggedUser"])->getId());
                        require_once(VIEWS_PATH."adm-form-screenings-cinemas.php");
                    }else{
                        if($screeningInDate->getRoom()->getCinema()->getOwner()->getEmail() == $_SESSION["loggedUser"]){
                            $this->showFormScreeningTime($idMovie, $date, $screeningInDate->getRoom()->getCinema()->getId(), $screeningInDate->getRoom()->getId());
                        }else{
                            $this->showFormScreening($idMovie, "Ya hay un cine reproduciendo esa pelicula en este mismo dia.");
                        }
                    }
                }else{
                    $this->showFormScreening($idMovie);
                }

            }catch(Exception $e){
                $this->showListView("No fue posible establecer una conexion con la Base de Datos.");
            }
        }

        public function showFormScreeningSelectRoom($idMovie, $date, $idCinema){
                
            try{
                $movieDao = new MovieDAO();

                $movie = $movieDao->getByIdAPI($idMovie);

                $cinemaDao = new CinemaDAO();

                $cinema = $cinemaDao->getById($idCinema);
                
                $roomDao = new RoomDAO();
                
                $roomList = $roomDao->getByCinemaId($idCinema);

                require_once(VIEWS_PATH."adm-form-screenings-rooms.php");

            }catch(Exception $e){
                $this->showListView("No fue posible establecer una conexion con la Base de Datos.");
            }
        }

        public function showFormScreeningTime($idMovie, $date, $idCinema, $idRoom, $message = ""){
            
            try{
                $movieDao = new MovieDAO();

                $movie = $movieDao->getByIdAPI($idMovie);

                $cinemaDao = new CinemaDAO();

                $cinema = $cinemaDao->getById($idCinema);
                
                $roomDao = new RoomDAO();

                $room = $roomDao->getById($idRoom);

                date_default_timezone_set("America/Argentina/Buenos_Aires");//ESTO MODIFICA EL TIMEZON QUE USA LA PAGINA

                require_once(VIEWS_PATH."adm-form-screenings-time.php");
            
            }catch(Exception $e){
                $this->showListView("No fue posible establecer una conexion con la Base de Datos.");
            }
        }

        private function checkTime($time, $idRoom, $date, $idMovie){
            $screeningDAO = new ScreeningDAO();
            $screenings = $screeningDAO->getByRoomAndDate($idRoom, $date);
            $result = TRUE;

            $timeActual = new datetime($time);

            //Busca la funcion anterior y posterior si las hay. Si hay una funcion en el mismo horario cambia el resultado.
            if(count($screenings) > 0){
                $passed = FALSE;

                foreach($screenings as $row){
                    $timeScreening = new datetime($row->getTime());

                    if($timeScreening < $timeActual){
                        $anterior = $row;
                    }else{
                        if($timeScreening > $timeActual && $passed == FALSE){
                            $posterior = $row;
                            $passed = TRUE;
                        }else{
                            $result = FALSE;
                        }
                    }
                }
            }

            //Si hay una funcion anterior corrobora el horario.
            if(isset($anterior) && $result == TRUE){
                
                $runtime = $anterior->getRuntime() + 15 ;
                $hours = floor($runtime / 60);
                $minutes = floor($runtime - ($hours * 60));

                $hourFinishAnterior = new datetime ($anterior->getTime());
                $hourFinishAnterior->modify('+'.$hours." hour");
                $hourFinishAnterior->modify('+'.$minutes."minutes");

                if($hourFinishAnterior < $timeActual){
                    $result = TRUE;
                }else{
                    $result = FALSE;
                }
            }

            //Si hay una funcion posterior corrobora el horario.
            if(isset($posterior) && $result == TRUE){

                $hourStartPosterior = new datetime ($posterior->getTime());

                $movieDao = new MovieDAO();

                $runtimeActual = $movieDao->getRuntimeAPI($idMovie) + 15 ;
                $hoursActual = floor($runtimeActual / 60);
                $minutesActual = floor($runtimeActual - ($hoursActual * 60));

                $hourFinishActual = new datetime ($time);
                $hourFinishActual->modify('+'.$hoursActual." hour");
                $hourFinishActual->modify('+'.$minutesActual."minutes");

                if($hourStartPosterior > $hourFinishActual){
                    $result = TRUE;
                }else{
                    $result = FALSE;
                }
            }

            return $result;
        }

        //HORA TEST
        private function checkTime2($time, $idRoom, $date, $idMovie){
            $screeningDAO = new ScreeningDAO();

            $fechaAnterior = date("Y-m-d",strtotime($date."- 1 days"));
            $fechaPosterior = date("Y-m-d",strtotime($date."+ 1 days"));

            $screenings = array();
            foreach($screeningDAO->getByRoomAndDate($idRoom, $fechaAnterior) as $row){
                array_push($screenings, $row);
            }
            foreach($screeningDAO->getByRoomAndDate($idRoom, $date) as $row){
                array_push($screenings, $row);
            }
            foreach($screeningDAO->getByRoomAndDate($idRoom, $fechaPosterior) as $row){
                array_push($screenings, $row);
            }

            $result = TRUE;

            $timeActual = new datetime($time);

            //Busca la funcion anterior y posterior si las hay. Si hay una funcion en el mismo horario cambia el resultado.
            if(count($screenings) > 0){
                $passed = FALSE;

                foreach($screenings as $row){
                    $timeScreening = new datetime($row->getTime());

                    if($timeScreening < $timeActual){
                        $anterior = $row;
                    }else{
                        if($timeScreening > $timeActual && $passed == FALSE){
                            $posterior = $row;
                            $passed = TRUE;
                        }else{
                            $result = FALSE;
                        }
                    }
                }
            }

            //Si hay una funcion anterior corrobora el horario.
            if(isset($anterior) && $result == TRUE){
                
                $runtime = $anterior->getRuntime() + 15 ;
                $hours = floor($runtime / 60);
                $minutes = floor($runtime - ($hours * 60));

                $hourFinishAnterior = new datetime ($anterior->getTime());
                $hourFinishAnterior->modify('+'.$hours." hour");
                $hourFinishAnterior->modify('+'.$minutes."minutes");

                if(strtotime($hourFinishAnterior->format('Y-m-d H:i:s')) < strtotime($timeActual->format('Y-m-d H:i:s'))){
                    $result = TRUE;
                }else{
                    $result = FALSE;
                }
            }

            //Si hay una funcion posterior corrobora el horario.
            if(isset($posterior) && $result == TRUE){

                $hourStartPosterior = new datetime ($posterior->getTime());

                $movieDao = new MovieDAO();

                $runtimeActual = $movieDao->getRuntimeAPI($idMovie) + 15 ;
                $hoursActual = floor($runtimeActual / 60);
                $minutesActual = floor($runtimeActual - ($hoursActual * 60));

                $hourFinishActual = new datetime ($time);
                $hourFinishActual->modify('+'.$hoursActual." hour");
                $hourFinishActual->modify('+'.$minutesActual."minutes");

                if(strtotime($hourStartPosterior->format('Y-m-d H:i:s')) > strtotime($hourFinishActual->format('Y-m-d H:i:s'))){
                    $result = TRUE;
                }else{
                    $result = FALSE;
                }
            }

            return $result;
        }

        public function addScreening($idMovie, $date, $idCinema, $idRoom, $time){

            try{

                if($this->checkTime($time, $idRoom, $date, $idMovie)){

                    $movieDao = new MovieDAO();
                    $movie = $movieDao->getById($idMovie);

                    if($movie == NULL){
                        $movie = $movieDao->getByIdAPI($idMovie);
                        $movieDao->add($movie);
                        $movie = $movieDao->getById($idMovie);
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
                                    
                }else {
                    $this->showFormScreeningTime($idMovie, $date, $idCinema, $idRoom, "No es posible agregar la función en el horario seleccionado");
                }

            }catch(Exception $e){
                $this->showListView("No fue posible establecer una conexion con la Base de Datos.");
            }

        }

        public function deleteScreening($id){
                
            try{
                $this->screeningDao = new ScreeningDAO();
                $this->screeningDao->deleteById($id);

                $this->showListView();

            }catch(Exception $e){
                $this->showListView("No fue posible establecer una conexion con la Base de Datos.");
            }
        }
    }

?>