<?php

namespace DAO;

use Models\Cinema as Cinema;
use DAO\ICinemaDAO as ICinemaDAO;


class CinemaDAO implements ICinemaDAO {

    private $cinemasList = array();

    public function getByName($name) {
        
        $this->retrieveData();

        $cinemas = array();

        foreach ($this->cinemasList as $row){
            if($name == $row->getName()){
                $cinema = new Cinema();
                $cinema->setId($row->getId());
                $cinema->setName($row->getName());
                $cinema->setCapacity($row->getCapacity());
                $cinema->setAddress($row->getAddress());
                $cinema->setPrice($row->getPrice());
                $cinema->setOwner($row->getOwner());

                array_push($cinemas, $cinema);
            }
        }
        return $cinemas;
    }

    public function getByOwner($owner) {
        
        $this->retrieveData();

        $cinemas = array();

        foreach ($this->cinemasList as $row){
            if($owner == $row->getOwner()){
                $cinema = new Cinema();
                $cinema->setId($row->getId());
                $cinema->setName($row->getName());
                $cinema->setCapacity($row->getCapacity());
                $cinema->setAddress($row->getAddress());
                $cinema->setPrice($row->getPrice());
                $cinema->setOwner($row->getOwner());

                array_push($cinemas, $cinema);
            }
        }
        return $cinemas;
    }

    public function getById($id){

        $this->retrieveData();

        $cinema = new Cinema();

        foreach ($this->cinemasList as $row){
            if($id == $row->getId()){
                $cinema->setId($row->getId());
                $cinema->setName($row->getName());
                $cinema->setCapacity($row->getCapacity());
                $cinema->setAddress($row->getAddress());
                $cinema->setPrice($row->getPrice());
                $cinema->setOwner($row->getOwner());

            }
        }
        return $cinema;
    }

    public function getAll(){

        $this->retrieveData();

        return $this->cinemasList;

    }

    public function add($name, $capacity, $address, $price, $owner){
        $cinema = new Cinema();
        $cinema->setName($name);
        $cinema->setCapacity($capacity);
        $cinema->setAddress($address);
        $cinema->setPrice($price);
        $cinema->setOwner($owner);
        $cinema->setId($this->createIdCinema());
        
        $this->retrieveData();

        array_push($this->cinemasList, $cinema);
        
        $this->saveData();
    }

    public function deleteById($id){
        $this->retrieveData();

        $cinemas = array();

        foreach($this->cinemasList as $row){
            if($id != $row->getId()){
                $cinema = new Cinema ();
                $cinema->setId($row->getId());
                $cinema->setName($row->getName());
                $cinema->setCapacity($row->getCapacity());
                $cinema->setAddress($row->getAddress());
                $cinema->setPrice($row->getPrice());
                $cinema->setOwner($row->getOwner());

                array_push($cinemas, $cinema);
            }
        }
        $this->cinemasList = $cinemas;
        $this->saveData();
        
    }

    public function update($id, $name, $capacity, $address, $price, $owner){
        $this->retrieveData();

        $cinemas = array();

         foreach($this->cinemasList as $row){
             if($id == $row->getId()){
                $cinema = new Cinema ();
                $cinema->setId($id);
                $cinema->setName($name);
                $cinema->setCapacity($capacity);
                $cinema->setAddress($address);
                $cinema->setPrice($price);
                $cinema->setOwner($owner);

                array_push($cinemas, $cinema);
             }else{
                $cinema = new Cinema ();
                $cinema->setId($row->getId());
                $cinema->setName($row->getName());
                $cinema->setCapacity($row->getCapacity());
                $cinema->setAddress($row->getAddress());
                $cinema->setPrice($row->getPrice());
                $cinema->setOwner($row->getOwner());

                array_push($cinemas, $cinema);
             }
         }
         $this->cinemasList = $cinemas;
         $this->saveData();
    }

    private function createIdCinema(){
        $this->retrieveData();

        $newId = 0;

        foreach($this->cinemasList as $cinema){
            $newId = $cinema->getId();
        }
        $newId ++;
        echo $newId;
        return $newId;
    }

    private function retrieveData(){
        $this->cinemasList = array();

        $jsonPath = $this->getJsonFilePath();

        $jsonContent = file_get_contents($jsonPath);
        
        $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

        foreach ($arrayToDecode as $row) {
            $cinema = new Cinema();
            $cinema->setId($row['id']);
            $cinema->setName($row['name']);
            $cinema->setCapacity($row['capacity']);
            $cinema->setAddress($row['address']);
            $cinema->setPrice($row['price']);
            $cinema->setOwner($row['owner']);

            array_push($this->cinemasList, $cinema);
        }
    }

    private function saveData(){
        $arrayToEncode = array();

        $jsonPath = $this->getJsonFilePath();

        foreach ($this->cinemasList as $cinema) {
            $valueArray['id'] = $cinema->getId();
            $valueArray['name'] = $cinema->getName();
            $valueArray['capacity'] = $cinema->getCapacity();
            $valueArray['address'] = $cinema->getAddress();
            $valueArray['price'] = $cinema->getPrice();
            $valueArray['owner'] = $cinema->getOwner();

            array_push($arrayToEncode, $valueArray);

        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($jsonPath, $jsonContent);
    }

    private function getJsonFilePath(){

        $initialPath = "Data/cinemas.json";
        if(file_exists($initialPath)){
            $jsonFilePath = $initialPath;
        }else{
            $jsonFilePath = "../".$initialPath;
        }

        return $jsonFilePath;
    }
}
?>