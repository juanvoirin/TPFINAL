<?

    namespace DAO;

    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Movie as movie;
    use Models\genre as genre;

    class MxgDAO {

        public function add(Movie $movie){

            $query = "CALL MxG_Add";

            
            $parameters["id_movie"] = $movie->getId();
            $parameters["id_genre"] = $movie->getGenre();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

         }

         public function getMoviesByIdgenre($id){

            $query = "CALL GetMoviesByIdGenre";

            $parameters ["id_genre"] = $id;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoreProcedure);

            //Funcion para que traiga Movies por id de genero, pero creo que la planteo mal.

         }

    }