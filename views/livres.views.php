<?php

ob_start(); 

if (isset($_SESSION['alert'])) { ?>
    <div class="alert alert-<?= $_SESSION['alert']['type']  ?>"> <?= $_SESSION['alert']['msg']  ?> </div>
<?php unset($_SESSION['alert']); } ?>


<table class="table text-center">
    <tr class="table-dark">
        <th>Image</th>
        <th>Titre</th>
        <th>Nombre de pages</th>
        <th colspan="2">Actions</th>
    </tr>
    <?php
        
        for ($i=0; $i < count($livres) ; $i++) :
    ?>
        <tr>
            <td class="align-middle"><img src="public/images/<?= $livres[$i]->getImage();?>" width="60px"></td>
            <td class="align-middle"><a href="<?= URL ?>livres/l/<?= $livres[$i]->getId() ?>"><?= $livres[$i]->getTitre(); ?></a></td>
            <td class="align-middle"><?= $livres[$i]->getNbPages(); ?></td>
            <td class="align-middle">
                <form method="POST" action="<?= URL ?>livres/m/<?= $livres[$i]->getId() ?>" >
                    <button type="submit" class="btn btn-warning">Modifier</button>
                </form>
            </td>
            <td class="align-middle">
                <form method="POST" action="<?= URL ?>livres/s/<?= $livres[$i]->getId() ?>"  onSubmit="return confirm('Voulez-vous vraiment supprimer ce livre?')" >
                    <button type="submit" class="btn btn-danger">Supprimer</button>
               </form>
            </td>
        </tr>
    <?php endfor; ?>
</table>
<a href="<?= URL ?>livres/a" class="btn btn-success d-block">Ajouter</a>
<?php
$titre="Les livres du bibliothèque MGA";
$content=ob_get_clean();
require 'template.php';
?>