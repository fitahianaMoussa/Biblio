<?php

ob_start(); 
?>
<form  method='POST' action="<?= URL ?>livres/mv" enctype="multipart/form-data">
    <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" for="titre" name="livre" class="form-control" value="<?= $livre->getTitre() ?>">
    </div>
    <div class="form-group">
        <label for="nombre">Nombre de pages</label>
        <input type="number" for="nombre" name="nbPages" class="form-control" value="<?= $livre->getNbPages() ?>">
    </div>
    <img src="<?= URL ?>public/images/<?= $livre->getImage() ?>" >
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" for="image" name="image" class="form-control-file">
    </div>
    <input type="hidden" name="identifiant"  value="<?= $livre->getId() ?>" >
    <button class="btn btn-info d-block" type="submit">Valider</button>
</form>


<?php
$titre="Modifier un livre";
$content=ob_get_clean();
require 'template.php';
?>