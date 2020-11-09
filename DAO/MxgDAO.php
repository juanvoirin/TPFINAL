<?php

    namespace DAO;

    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Movie as movie;
    use Models\genre as genre;
    use DAO\IMxgDAO as IMxgDAO;
use Models\Mxg;

class MxgDAO implements IMxgDAO {

        public function add($idMovie, $idGenre){

            $query = "CALL moviesXgenres_Add(?,?)";

            $parameters["id_movie"] = $idMovie;
            $parameters["id_genre"] = $idGenre;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

         public function getMoviesByIdgenre($id_genre){

            $query = "CALL Mxg_GetMoviesByIdGenre(?)";

            $parameters ["id_genre"] = $id_genre;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            $this->mxgList = array();

            if($result != NULL){
                foreach($result as $row){
                    $mxg = new Mxg();
                    $mxg->setId_movie($row['id_movie']);
                    $mxg->setId_genre($row['id_genre']);

                    array_push($this->mxgList, $mxg);
                }

            }

            return $this->mxgList;

        }

        public function getIdGenresByIdMovie($idMovie){

            $query = "CALL Mxg_GetGenresByIdMovie(?)";

            $parameters["idMovie"] = $idMovie;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            return $result;

        }

    }

?>