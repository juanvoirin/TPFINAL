<?php

    namespace DAO;
    
    use Models\Room as Room;

    interface IRoomDAO {

        function getByCinemaId($cinemaId);
        function add(Room $room);
        function deleteByid($id);
        function GetById($id);
        function update(Room $room);


    }
?>