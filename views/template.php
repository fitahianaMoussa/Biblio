<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?=URL?>/css/style.css">
  <title>Document</title>
</head>
<body>


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="#" class="navbar-brand">Biblio</a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a href="<?= URL ?>acceuil" class="nav-link">Acceuil</a>
      </li>
      <li class="nav-item">
        <a href="<?= URL ?>livres" class="nav-link">Livres</a>
      </li>
    </ul>
  </nav>
    <div class="container">
        <h1 class="border border-dark rounded p-2 m-2 text-center text-white bg-info"><?= $titre ?></h1>
        <?= $content ?>
    </div>
   
</body>
</html>

