<?php

require_once 'Models/Model.php';

class ApiManager extends Model{

    function getDBAnimaux(){
        $sql = "SELECT * FROM animal inner join animal_continent, continent, famille where animal.famille_id=famille.famille_id AND animal_continent.animal_id = animal.animal_id AND continent.continent_id = animal_continent.continent_id";
        $req = $this->getDB()->prepare($sql);
        $req->execute();
        $animaux = $req->fetchAll(PDO::FETCH_OBJ);
        return $animaux;
    }

    function getDBAnimal($id){
        $sql = "SELECT * FROM animal inner join animal_continent, continent, famille where animal.famille_id=famille.famille_id AND animal_continent.animal_id = animal.animal_id AND continent.continent_id = animal_continent.continent_id AND animal.animal_id = :id";
        $req = $this->getDB()->prepare($sql);
        $req->execute([':id' => $id]);
        $animal = $req->fetchAll(PDO::FETCH_OBJ);
        return $animal;
    }

    function getDBContinents(){
        $sql = "SELECT * FROM continent";
        $req = $this->getDB()->prepare($sql);
        $req->execute();
        $continent = $req->fetchAll(PDO::FETCH_OBJ);
        return $continent;
    }

    function getDBFamilles(){
        $sql = "SELECT * FROM famille";
        $req = $this->getDB()->prepare($sql);
        $req->execute();
        $famille = $req->fetchAll(PDO::FETCH_OBJ);
        return $famille;
    }
    
}