<?php ob_start();

?>

<h1 class="mt-3">Ma page d'acceuil</h1>


<?php
$titre="Bibliothèque MGA";
$content=ob_get_clean();
require 'template.php';
?>