<?php
    require_once 'Model.class.php';
    require 'Livre.class.php';
   
    class LivreManager extends Model{
        private $livres;//tableau de livre


        public function ajouterLivre($livre){
            $this->livres[] = $livre;
        }

        public function getLivres(){
            return $this->livres;
        }

        public function chargementLivres(){
            $req = $this->getBdd()->prepare("SELECT * FROM livre");
            $req->execute();
            $livresBD = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();

            foreach ($livresBD as $livre) {
                $l = new Livre($livre['id'],$livre['livre'],$livre['nbPages'],$livre['image']);
                $this->ajouterLivre($l);
            }
        }

        public function getLivreById($id){
            for ($i = 0; $i < count($this->livres) ; $i++) { 
                if ($this->livres[$i]->getId() === $id) {
                    return $this->livres[$i];
                }
            }
            throw new Exception("Le livre n'existe pas");
        }

        public function ajouterLivreBDD($livre,$nbPages,$image){
            $requette = "INSERT INTO livre (livre, nbPages, image) values (:livre,:nbPages,:image)";
            $stmt = $this->getBdd()->prepare($requette);
            $stmt->bindValue(":livre",$livre,PDO::PARAM_STR);
            $stmt->bindValue(":nbPages",$nbPages,PDO::PARAM_INT);
            $stmt->bindValue(":image",$image,PDO::PARAM_STR);
            $resultat = $stmt->execute();
            $stmt->closeCursor();
            if ($resultat > 0) {
                $livre = new Livre($this->getBDD()->lastInsertId(),$livre,$nbPages,$image);//creation d'un livre
                $this->ajouterLivre($livre);//ajout du livre dans le tableu $livres
            }
        }

        private function suppressionLivreDansTableau($id){
            for ($i = 0; $i < count($this->livres); $i++) { 
                if ($this->livres[$i]->getId() === $id) {
                    unset($this->livres[$i]);
                }
            }
        }

        public function supprimerLivreBDD($id){
            $req = "DELETE FROM livre WHERE id=:idLivre";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":idLivre",$id,PDO::PARAM_INT);
            $resultat = $stmt->execute();
            $stmt->closeCursor();
            if($resultat > 0){
                $this->suppressionLivreDansTableau($id);
            }
        }

        public function modificationLivreBDD($id,$livre,$nbPages,$image){
            $req = "UPDATE livre SET livre = :livre, nbPages = :nbPages, image = :image WHERE id = :id";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":id",$id,PDO::PARAM_INT);
            $stmt->bindValue(":livre",$livre,PDO::PARAM_STR);
            $stmt->bindValue(":nbPages",$nbPages,PDO::PARAM_INT);
            $stmt->bindValue(":image",$image,PDO::PARAM_STR);
            $resultat = $stmt->execute();
            $stmt->closeCursor();

            if ($resultat > 0) {
                $this->getLivreById($id)->setTitre($livre);
                $this->getLivreById($id)->setNbPages($nbPages);
                $this->getLivreById($id)->setImage($image);
            }
        }
    }


?>