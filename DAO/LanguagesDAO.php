<?php

    namespace DAO;

    class LanguagesDAO implements ILanguagesDAO {

        public function getByCode($code){
    
            $jsonPath = $this->getJsonFilePath();
    
            $jsonContent = file_get_contents($jsonPath);
            
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            $language = "No specified.";
    
            foreach ($arrayToDecode as $row) {
                if($row['code'] == $code){
                    $language = $row['name'];
                }
            }

            return $language;
        }
    
        private function getJsonFilePath(){
    
            $initialPath = "Data/languages.json";
            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }
    
            return $jsonFilePath;
        }

    }

?>