<?php

    namespace Controllers;

    use Models\Ticket as Ticket;
    use DAO\TicketDAO as TicketDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\MovieDAO as MovieDAO;
    use DAO\ScreeningDAO as ScreeningDAO;
    use DAO\UserDAO as UserDAO;
    use \Exception as Exception;

    class TicketController
    {

        public function index($message = ""){

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

        public function showListViewMoviesByOwner($message = ""){

            try{
                $list = array();

                $ticketDao = new TicketDAO();
                $userDao = new UserDAO();
                $screeningDao = new ScreeningDAO();

                $idUser = $userDao->getByEmail($_SESSION["loggedUser"])->getId();

                $result = $ticketDao->getListMoviesByOwner($idUser);

                foreach($result as $row){
                    $ticket['movie'] = $row['title'];
                    $ticket['sold'] = $row['sold'];
                    $ticket['remaining'] = $screeningDao->getCapacityByMovie($row['idMovie'], $idUser) - $row['sold'];
    
                    array_push($list, $ticket);
                }

            }catch(Exception $e){
                $message = "No fue posible establecer una conexion con la Base de Datos.";
            }

            require_once(VIEWS_PATH."adm-list-tickets-movies.php");
        }

        public function showListViewScreeningsByOwner($message = ""){

            try{
                $list = array();

                $userDao = new UserDAO();
                $screeningDao = new ScreeningDAO();

                $idUser = $userDao->getByEmail($_SESSION["loggedUser"])->getId();

                $list = $screeningDao->getByOwner($idUser);

            }catch(Exception $e){
                $message = "No fue posible establecer una conexion con la Base de Datos.";
            }

            require_once(VIEWS_PATH."adm-list-tickets-screenings.php");
        }

        public function showListViewCinemasByOwner($message = ""){

            try{
                $list = array();

                $userDao = new UserDAO();
                $screeningDao = new ScreeningDAO();
                $ticketDao = new TicketDAO();

                $idUser = $userDao->getByEmail($_SESSION["loggedUser"])->getId();

                $listCinemas = $ticketDao->getListCinemasByOwner($idUser);

                foreach($listCinemas as $row){
                    $array["cinema"] = $row["cinema"];
                    $array["sold"] = $row["sold"];
                    $array["remaining"] = ($screeningDao->getCapacityByCinema($row["idCinema"]) - $row["sold"]);
                    $array["rooms"] = $ticketDao->getListRoomsByCinema($row["idCinema"]);

                    array_push($list, $array);
                }

            }catch(Exception $e){
                $message = "No fue posible establecer una conexion con la Base de Datos.";
            }

            require_once(VIEWS_PATH."adm-list-tickets-cinemas.php");
        }

        public function showListViewByUser($message = ""){

            try{
                if(isset($_SESSION["type"]) && $_SESSION["type"] != "administrator"){
                    $ticketsList = array();

                    $ticketDao = new TicketDAO();
                    $userDao = new UserDAO();

                    $ticketsList = $ticketDao->getByUser($userDao->getByEmail($_SESSION["loggedUser"])->getId());
                }else{
                    $this->index();
                }

            }catch(Exception $e){
                $message = "No fue posible establecer una conexion con la Base de Datos.";
            }

            require_once(VIEWS_PATH."user-list-tickets.php");
        }

        public function addTicketForm($idScreening){

            try{
                if(isset($_SESSION["type"]) && $_SESSION["type"] != "administrator"){
                    $screeningDao = new ScreeningDAO();
                    $ticketDao = new TicketDAO();

                    $screening = $screeningDao->getById($idScreening);
                    $ticketAvailability = ($screening->getRoom()->getCapacity()) - ($ticketDao->getAvailability($screening->getId()));
                    
                    require_once(VIEWS_PATH."usr-form-tickets.php");
                }else{
                    $this->index();
                }

            }catch(Exception $e){
                $this->showListViewByUser("Ocurrio un error en la redireccion hacia el formulario para un nuevo ticket.");
            }
        }

        public function addTicket($idScreening, $quantity){

            try{
                if(isset($_SESSION["type"]) && $_SESSION["type"] != "administrator"){
                    $ticketDao = new TicketDAO();
                    $userDao = new UserDAO();
                    $screeningDao = new ScreeningDAO();

                    $ticket = new Ticket();
                    $ticket->setScreening($screeningDao->getById($idScreening));
                    $ticket->setUser($userDao->getByEmail($_SESSION["loggedUser"]));

                    $i = 0;

                    while($i < $quantity){
                        $ticketDao->add($ticket);
                        $i++;
                    }
                    
                    $screeningDao->sumSoldScreening($idScreening, $quantity);

                    if($quantity > 1){
                        $this->showListViewByUser("Tickets comprados correctamente.");
                    }else{
                        $this->showListViewByUser("Ticket comprado correctamente.");
                    }
                }else{
                    $this->index();
                }

            }catch(Exception $e){
                $this->showListViewByUser("Ocurrio un error al intentar comprar un ticket.");
            }
        }
    

        public function soldTicketsMovieForm(){

            try{
                if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator"){
                    $movieDao = new MovieDAO();
                    $userDao = new UserDAO();

                    $movieList = array();
                    $movieList = $movieDao->getMovieWithScreeningByOwner($userDao->getByEmail($_SESSION["loggedUser"])->getId());
                    
                    require_once(VIEWS_PATH."adm-form-tickets-movies-sold.php");
                }else{
                    $this->index();
                }

            }catch(Exception $e){
                $this->index("No fue posible establecer una conexion con la Base de Datos.");
            }
        }

        public function soldTicketsByIdMovie($id_movie, $date_1, $date_2){
            try{
                if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator"){
                    $ticketDao = new TicketDAO();
                    $movieDao = new MovieDAO();

                    $movie = $movieDao->getById($id_movie);
                    $quantity = $ticketDao->getSoldByIdMovie($id_movie, $date_1, $date_2);
                    $date1 = $date_1;
                    $date2 = $date_2;

                    require_once(VIEWS_PATH."adm-list-tickets-sold.php");
                }else{
                    $this->index();
                }
            }catch(Exception $e){
                $this->index("No fue posible establecer una conexion con la Base de Datos.");
            }
        }

        public function soldTicketsByIdCinema($id_cinema, $date_1, $date_2){
            try{
                if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator"){
                    $ticketDao = new TicketDAO();
                    $cinemaDao = new CinemaDAO();

                    $cinema = $cinemaDao->getById($id_cinema);
                    $quantity = $ticketDao->getSoldByIdCinema($id_cinema, $date_1, $date_2);
                    $date1 = $date_1;
                    $date2 = $date_2;

                    require_once(VIEWS_PATH."adm-list-tickets-cinemas-sold.php");
                }else{
                    $this->index();
                }
            }catch(Exception $e){
                $this->index("No fue posible establecer una conexion con la Base de Datos.");
            }
        }

        public function soldTicketsCinemaForm(){

            try{
                if(isset($_SESSION["type"]) && $_SESSION["type"] == "administrator"){
                    $ticketDao = new TicketDAO();
                    $cinemaDao = new CinemaDAO();
                    $userDao = new UserDAO();
                 
                    $cinemasList = $cinemaDao->getByOwnerId($userDao->getByEmail($_SESSION["loggedUser"])->getId());
                    
                    require_once(VIEWS_PATH."adm-form-tickets-cinema-sold.php");
                }else{
                    $this->index();
                }

            }catch(Exception $e){
                $this->index("No fue posible establecer una conexion con la Base de Datos.");
            }
        }

        public function showQR($idTicket) {
            
            try{
                $ticketDao = new TicketDAO();

                $ticket = $ticketDao->getTicketById($idTicket);

                if($ticket != NULL){
                    $qrInfo = $ticket->getQrInfo();
                    require_once(VIEWS_PATH."usr-qr-ticket.php");
                }else{
                    $this->index("No fue posible establecer una conexion con la Base de Datos.");
                }
            }catch(Exception $e){
                $this->index("No fue posible establecer una conexion con la Base de Datos.");
            }
		}

    }
?>