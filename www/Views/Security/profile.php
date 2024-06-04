<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./css/navbar.css">
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <a href="#">Accueil</a>
    <a href="#">Profil</a>
  
    <?php
    if (isset($pages) && !empty($pages)) {
        foreach ($pages as $page) {
            echo "<a href='/page/showPage?id={$page->getId()}'>{$page->getTitle()}</a>";
        }
    }
    ?>
    <a href="/security/logout">Déconnexion</a>
  </div>

  <!-- Contenu de la page -->
  <h1>Profile</h1>
  <p>Vous êtes connecté en tant que <?= htmlspecialchars($authUser->getLastname(), ENT_QUOTES, 'UTF-8') ?></p>
  <p>Prénom: <?= htmlspecialchars($authUser->getFirstname(), ENT_QUOTES, 'UTF-8') ?></p>
  <p>Nom: <?= htmlspecialchars($authUser->getLastname(), ENT_QUOTES, 'UTF-8') ?></p>
  <p>Email: <?= htmlspecialchars($authUser->getEmail(), ENT_QUOTES, 'UTF-8') ?></p>
  <p>session id: <?= htmlspecialchars($_SESSION['user_id'], ENT_QUOTES, 'UTF-8') ?></p>

</body>
</html>
