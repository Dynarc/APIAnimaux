<?php
session_start();
define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once 'Controllers/front/ApiController.php';

if(empty($_GET['page'])){

    echo 'page inexistante';

} else{

    $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);

    try {

        switch ($url[0]){

            case 'Front':

                $ApiController = new ApiController;

                if(empty($url[1])){
                    throw new Exception("Cette page n'existe pas");
                } else{

                    switch ($url[1]){                
                        case 'Animaux':
                            $ApiController->getAnimaux();
                        break;

                        case 'Animal':
                            if(!empty($url[2])){
                                $ApiController->getAnimal($url[2]);
                            } else throw new Exception("Aucun animal n'est selectionné ");
                        break;

                        case 'Continents':
                            $ApiController->getContinents();
                        break;

                        case 'Familles':
                            $ApiController->getFamilles();
                        break;

                        default:
                            throw new Exception("La page n'existe pas");
                        break;
                    }

                }
                
            break;

            default:
                throw new Exception("La page n'existe pas");
            break;

        }

    }catch (Exception $e){
        echo $e->getMessage();
    }
}