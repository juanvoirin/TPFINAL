<?php

    namespace Controllers;

    class UserController {

        public function index($message = ""){
            require_once(VIEWS_PATH."login.php");
        }

        public function showHomeView(){
            require_once(VIEWS_PATH."home.php");
        }

        public function login($email, $pass){
            if($email == "user@myapp.com"){
                if($pass == "123456"){
                    $_SESSION["loggedUser"] = 1; //Aca va el id del usuario
                    $_SESSION["userName"] = $email;
                    $this->showHomeView();
                }else{
                    echo "<script> if(confirm('Verifique que la contraseña sea correcta. (ES 123456)'));";
                    echo "window.location = '../index.php';</script>";
                }
            }else{
                echo "<script> if(confirm('Verifique que el email sea correcto. (ES user@myapp.com)'));";
                echo "window.location = '../index.php';</script>";
            }
        }

        public function logout(){
            session_destroy();

            $this->index();
        }

        public function add($name, $email, $pass){
            
            $arrayToEncode = array();

            $valueArray['name'] = $name;
            $valueArray['email'] = $email;
            $valueArray['pass'] = $pass;

            array_push($arrayToEncode, $valueArray);

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents('Data/users.json', $jsonContent);

            require_once(VIEWS_PATH."login.php");
        }

    }