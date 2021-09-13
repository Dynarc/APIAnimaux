<?php

require_once 'Models/front/ApiManager.php';

class ApiController{
    private $APIManager;

    function __construct(){
        $this->APIManager = new ApiManager;
    }

    function getAnimaux(){
        Model::sendJson($this->formatJson($this->APIManager->getDBAnimaux()));
    }

    function getAnimal($id){
        Model::sendJson($this->formatJson($this->APIManager->getDBAnimal($id)));
    }

    function getContinents(){
        Model::sendJson($this->APIManager->getDBContinents());
    }

    function getFamilles(){
        Model::sendJson($this->APIManager->getDBFamilles());
    }

    private function formatJson($json){

        $checked = [];
        $newJson = [];
        // $index = 1;
        
        foreach ($json as $animal) {
            if(in_array($animal->animal_id,$checked)){
                continue;
            } else {
                $animal->id = $animal->animal_id;
                $animal->nom = $animal->animal_nom;
                $animal->description = $animal->animal_description;
                $animal->image = $animal->animal_image;
                $animal->famille = new stdClass;
                $animal->famille->idFamille = $animal->famille_id;
                $animal->famille->libelleFamille = $animal->famille_libelle;
                $animal->famille->descriptionFamille = $animal->famille_description;
                $animal->continents = array();
                $continent = new stdClass;
                $continent->continentId = $animal->continent_id;
                $continent->continentLibelle = $animal->continent_libelle;
                array_push($animal->continents,$continent);

                unset($animal->animal_id,$animal->animal_nom,$animal->animal_description,$animal->animal_image,$animal->famille_id,$animal->famille_libelle,$animal->famille_description,$animal->continent_id,$animal->continent_libelle);
                
                $i=1;

                foreach($json as $animalBis){
                    if(!empty($animalBis->animal_id)){
                        if($animal->id == $animalBis->animal_id){
                            array_push($animal->continents,new stdClass);
                            $animal->continents[$i]->continentId = $animalBis->continent_id;
                            $animal->continents[$i]->continentLibelle = $animalBis->continent_libelle;
                            $i++;
                        }
                    }
                    
                }
                array_push($checked, $animal->id);
                // array_push($newJson,$animal);
                $newJson[$animal->id]=$animal;
                // $index++;
            }
        }return($newJson); 
    }

}