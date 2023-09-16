<?php
require_once "model/livreManager.class.php";

class LivreController{
    private $livreManager;

    public function __construct(){
        $this->livreManager = new LivreManager();
        $this->livreManager->chargementLivres();
    }

    public function afficherLivres(){
        $livres = $this->livreManager->getLivres(); 
        require 'views/livres.views.php';
    }

    public function afficherLivre($id){
        $livre = $this->livreManager->getLivreById($id);
        require 'views/afficherLivre.views.php';
    }

    public function ajouterLivre(){
        require 'views/ajouterLivre.views.php';
    }

    public function ajouterImage($file,$directory){
        if(!isset($file['name']) || empty($file['name'])){
            throw new exception('Vous devez indiquer un image');
        }
        if(!file_exists($directory)){
            mkdir($directory,0777);
        }
        $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
        $random = rand(0,99999);
        $target_file = $directory.$random."_".$file['name'];
        if (!getimagesize($file['tmp_name'])) {
            throw new exception("Le fichier n'est pas un image");
        }
        if ($extension !== "jpg" && $extension !== "png" && $extension !== "gif" && $extension !== "JPG") {
            throw new exception("L'extension n'est pas reconnu");
        }
        if (file_exists($target_file)) {
            throw new exception("Le fichier est deja existé");
        }
        if ($file['size']>500000) {
            throw new exception("Le fichier est trop grand");
        }
        if (!move_uploaded_file($file['tmp_name'],$target_file)) {
            throw new exception("L'ajout de l'image ne fonctionne pas");
        }
        else {
            return ($random."_".$file['name']);
        }
    }


    public function ajouterLivreValidation(){
        $file = $_FILES['image'];
        $repertoire = "public/images/";
        $nomImage = $this->ajouterImage($file,$repertoire);//upload image
        $this->livreManager->ajouterLivreBDD($_POST['livre'],$_POST['nbPages'],$nomImage);//ajout d'un livre dans base
        $_SESSION['alert']=[
            "type"=>"Success",
            "msg"=>"Ajout avec succes"
        ];
        header("Location:".URL."livres");
    }

    public function suppressionLivre($id){
        $imageNom = $this->livreManager->getLivreById($id)->getImage();
        unlink("public/images/".$imageNom);//suppression de l'image
        $this->livreManager->supprimerLivreBDD($id);//suppression du livre dans bdd
        $_SESSION['alert']=[
            "type"=>"Success",
            "msg"=>"Suppression avec succes"
        ];
        header("Location:".URL."livres");

    }

    public function modifierLivre($id){
        $livre = $this->livreManager->getLivreById($id);
        require "views/modifierLivre.views.php";
    }

    public function modificationLivreValidation(){
        $imageActuelle = $this->livreManager->getLivreById($_POST['identifiant'])->getImage();
        $file = $_FILES['image'];
        if ($file['size'] > 0) {//si l'input de l'image n'est pas vide
            unlink("public/images/".$imageActuelle);//supprimer l'ancien image
            $repertoire = "public/images/";
            $nomToAdd = $this->ajouterImage($file,$repertoire);//ajouter le nouveau image
        }else {
            $nomToAdd = $imageActuelle;
        }
        $this->livreManager->modificationLivreBDD($_POST['identifiant'],$_POST['livre'],$_POST['nbPages'],$nomToAdd);
        $_SESSION['alert']=[
            "type"=>"Success",
            "msg"=>"Modification avec succes"
        ];
        header("Location:".URL."livres");
    }
}

?>