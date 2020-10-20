<?php

    namespace DAO;

    use Models\User as User;
    use DAO\IUserDAO as IUserDAO;
    

    class UserDAO implements IUserDAO {

        private $usersList = array();

        public function getByEmail($email) {
            
            $this->retrieveData();

            $user = null;

            foreach ($this->usersList as $row){
                if($email == $row->getEmail()){
                    $user = new User();
                    $user->setName($row->getName());
                    $user->setEmail($row->getEmail());
                    $user->setPass($row->getPass());
                    $user->setType($row->getType());
                }
            }
            return $user;
        }

        public function add($name, $email, $pass, $type){
            $user = new User();
            $user->setName($name);
            $user->setEmail($email);
            $user->setPass($pass);
            $user->setType($type);
            
            $this->retrieveData();

            array_push($this->usersList, $user);
            
            $this->saveData();
        }

        private function retrieveData(){
            $this->usersList = array();
    
            $jsonPath = $this->getJsonFilePath();
    
            $jsonContent = file_get_contents($jsonPath);
            
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
    
            foreach ($arrayToDecode as $row) {
                $user = new User();
                $user->setName($row['name']);
                $user->setEmail($row['email']);
                $user->setPass($row['pass']);
                $user->setType($row['type']);

                array_push($this->usersList, $user);
            }
        }

        private function saveData(){
            $arrayToEncode = array();
    
            $jsonPath = $this->getJsonFilePath();

            foreach ($this->usersList as $users) {
                $valueArray['name'] = $users->getName();
                $valueArray['email'] = $users->getEmail();
                $valueArray['pass'] = $users->getPass();
                $valueArray['type'] = $users->getType();
    
                array_push($arrayToEncode, $valueArray);
    
            }
            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($jsonPath, $jsonContent);
        }
    
        private function getJsonFilePath(){
    
            $initialPath = "Data/users.json";
            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }
    
            return $jsonFilePath;
        }
    }
?>