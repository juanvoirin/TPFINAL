<?php

    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\UserDAO as UserDAO;
    use Controllers\HomeController as HomeController;

    class UserController {

        private $userDao;

        public function index(){
            require_once(VIEWS_PATH."login.php");
        }

        public function showHomeView(){
            $this->genreDao = new GenreDAO();

            $genreList = array();
            $genreList = $this->genreDao->getAll();
            
            $this->movieDao = new MovieDAO();

            $movieList = array();
            $movieList = $this->movieDao->getAllAPI();

            require_once(VIEWS_PATH."home.php");
        }

        public function login($email, $pass){
            
            $this->userDao = new UserDAO();
            $user = $this->userDao->getByEmail($email);

            if($user == null){
                echo "<script> if(confirm('Verifique que el email sea correcto.'));";
                echo "window.location = '../index.php';</script>";
            }else{
                if($user->getPass() == $pass){
                    $_SESSION["loggedUser"] = $user->getEmail();
                    $_SESSION["userName"] = $user->getName();
                    $_SESSION["type"] = $user->getType();
                    $this->showHomeView();
                }else{
                    echo "<script> if(confirm('Verifique que la contraseña sea correcta.'));";
                    echo "window.location = '../index.php';</script>";
                }
            }
            $home = new HomeController();
            $home->showHomeView();
        }

        public function logout(){
            session_destroy();

            $this->index();
        }

        public function addUser($name, $email, $pass){

            $this->userDao = new UserDAO();
            $this->userDao->add($name, $email, $pass, "user");

            require_once(VIEWS_PATH."login.php");
        }

    }