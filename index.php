<?php

session_start();
define("URL",str_replace("index.php","",(isset($_SERVER['HTTPS'])? 'https' : 'http')."://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));
require_once "controller/livres.controller.php";
$livreController=new LivreController();

try {
    if(empty($_GET['page'])){
        require 'views/acceuil.views.php';
    }else {
        $url = explode('/',filter_var($_GET['page']),FILTER_SANITIZE_URL);
        
        switch ($url[0]) {
            case 'acceuil':
                require 'views/acceuil.views.php';
                break;
            case 'livres':
                if (empty($url[1])) {
                    $livreController->afficherLivres();  
                }elseif ($url[1] === "l") {
                    $livreController->afficherLivre($url[2]);
                }elseif ($url[1] === "a") {
                    $livreController->ajouterLivre();
                }elseif ($url[1] === "av") {
                    $livreController->ajouterLivreValidation();
                }elseif ($url[1] === "m") {
                    $livreController->modifierLivre($url[2]);
                }elseif ($url[1] === "mv") {
                    $livreController->modificationLivreValidation();
                }
                elseif ($url[1] === "s") {
                    $livreController->suppressionLivre($url[2]);
                }else {
                    throw new Exception("La page n'existe pas");
                }
                break;
            default:
                throw new Exception("La page n'existe pas");
                break;
        }
    }
} catch (Exception $e) {
    $msg= $e->getMessage();
    require "views/views.error.php";
}

?>