<?php

    namespace DAO;

    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Movie as movie;
    use Models\genre as genre;
    use DAO\IMxgDAO as IMxgDAO;

    class MxgDAO implements IMxgDAO {

        public function add($idMovie, $idGenre){

            $query = "CALL moviesXgenres_Add(?,?)";

            $parameters["id_movie"] = $idMovie;
            $parameters["id_genre"] = $idGenre;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

         public function getMoviesByIdgenre($id){

            $query = "CALL GetMoviesByIdGenre";

            $parameters ["id_genre"] = $id;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            //Funcion para que traiga Movies por id de genero, pero creo que la planteo mal.

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