<?php

    namespace Controllers;

    use Models\User as User;
    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\UserDAO as UserDAO;
    use Controllers\HomeController as HomeController;
    use \Exception as Exception;

    class UserController {

        private $userDao;
        private $genreDao;
        private $movieDao;

        public function index($message = ""){
                
            try{
                $genreDao = new GenreDAO();

                $genreList = array();
                $genreList = $genreDao->getAll();
                
                $movieDao = new MovieDAO();

                $movieList = array();
                $movieList = $movieDao->getMovieWithScreening();

            }catch(Exception $e){
                if(str_word_count($message) < 1){
                    $message = "No fue posible establecer una conexion con la Base de Datos.";
                }
            }

            require_once(VIEWS_PATH."login.php");
        }

        public function showHomeView($message = ""){
            
            try{
                $this->genreDao = new GenreDAO();

                $genreList = array();
                $genreList = $this->genreDao->getAll();

                $this->movieDao = new MovieDAO();

                $movieList = array();
                $movieList = $this->movieDao->getMovieWithScreening();

            }catch(Exception $e){
                $message = "No fue posible establecer una conexion con la Base de Datos.";
            }

            require_once(VIEWS_PATH."home.php");
        }

        public function login($email, $pass){
            
            try{

                $this->userDao = new UserDAO();
                $user = $this->userDao->getByEmail($email);

                if($user == null){
                    $message = "Verifique que el email sea correcto.";
                    $this->index($message);
                }else{
                    if($user->getPass() == $pass){
                        $_SESSION["loggedUser"] = $user->getEmail();
                        $_SESSION["userName"] = $user->getName();
                        $_SESSION["type"] = $user->getType();
                        $this->showHomeView();
                    }else{
                        $message = "Verifique que la contraseña sea correcta.";
                        $this->index($message);
                    }
                }
                $this->showHomeView();

            }catch(Exception $e){
                $this->index("No fue posible establecer una conexion con la Base de Datos.");
            }
        }

        public function logout(){
            session_destroy();

            $this->index();
        }

        public function addUser($name, $email, $pass){

            $user = new User();
            $user->setName($name);
            $user->setEmail($email);
            $user->setPass($pass);
            $user->setType("user");

            try{
                
                $this->userDao = new UserDAO();
                $this->userDao->add($user);

            }catch(Exception $e){
                $message = "Ocurrio un error al registrar el usuario.";
            }

            require_once(VIEWS_PATH."login.php");
        }

    }
?>