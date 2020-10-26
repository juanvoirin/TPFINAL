<?php

    namespace DAO;

    use Models\User as User;
    use DAO\IUserDAO as IUserDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    

    class UserDAO implements IUserDAO {

        private $usersList = array();
        private $connection;
        private $tableName = "users";

        public function getByEmail($email) {
            
            $query = "CALL Users_GetByEmail(?)";
            $parameters["email"] = $email;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,$parameters , QueryType::StoredProcedure);

            $user = new User();

            //userDao??            
        

            foreach ($result as $row){
                
                $user->setId($row['id']);
                $user->setName($row['name']);
                $user->setEmail($row['email']);
                $user->setPass($row['pass']);
                $user->setType($row['type']);
                
            }
            return $user;
        }

        public function getById($id){
            
            $query = "CALL Users_GetById(?)";
            $parameters["id"] = $id;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query,$parameters , QueryType::StoredProcedure);

            $user = new User();

            //userDao??            
        

            foreach ($result as $row){
     
                $user->setId($row['id']);
                $user->setName($row['name']);
                $user->setEmail($row['email']);
                $user->setPass($row['pass']);
                $user->setType($row['type']);
                
            }
            return $user;
        }

        public function getAll(){

            $this->usersList = array();

            $query = "CALL Users_GetAll()";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

            foreach($result as $row){
                $user = new User();
                $user->setId($row['id']);
                $user->setName($row['name']);
                $user->setEmail($row['email']);
                $user->setPass($row['pass']);
                $user->setType($row['type']);

                array_push($this->usersList, $user);
            }

            return $this->usersList;

        }


        public function add(User $user){
            
            $query = "CALL Users_Add(?,?,?,?)";
            
            $parameters["name"] = $user->getName();
            $parameters["email"] = $user->getEmail();
            $parameters["pass"] = $user->getPass();
            $parameters["type"] = $user->getType();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query,$parameters, QueryType::StoredProcedure);


        }

        public function deletebyEmail($email){

            $query = "CALL Users_Delete(?)";

            $parameters["email"] = $email;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        
        }


    }
?>