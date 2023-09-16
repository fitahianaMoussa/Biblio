<?php ob_start();

?>

<?= $msg ?>


<?php
$titre="Erreur!";
$content=ob_get_clean();
require 'template.php';
?>