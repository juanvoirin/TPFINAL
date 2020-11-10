<?php

    namespace Controllers;

    use Models\Ticket as Ticket;
    use DAO\TicketDAO as TicketDAO;
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

        public function showListViewByUser($message = ""){

            try{
                $ticketDao = new TicketDAO();
                $userDao = new UserDAO();

                $ticketsList = $ticketDao->getByUser($userDao->getByEmail($_SESSION["loggedUser"])->getId());

            }catch(Exception $e){
                $message = "No fue posible establecer una conexion con la Base de Datos.";
            }

            require_once(VIEWS_PATH."user-list-tickets.php");
        }

        public function addTicketForm($idScreening){

            try{

                $screeningDao = new ScreeningDAO();
                $ticketDao = new TicketDAO();

                $screening = $screeningDao->getById($idScreening);
                $ticketAvailability = ($screening->getRoom()->getCapacity()) - ($ticketDao->getAvailability($screening->getId()));
                
                require_once(VIEWS_PATH."usr-form-tickets.php");

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

                    if($quantity > 1){
                        $this->showListViewByUser("Tickets comprados correctamente.");
                    }else{
                        $this->showListViewByUser("Ticket comprado correctamente.");
                    }
                }

            }catch(Exception $e){
                $this->showListViewByUser("Ocurrio un error al intentar comprar un ticket.");
            }
        }

    }
?>