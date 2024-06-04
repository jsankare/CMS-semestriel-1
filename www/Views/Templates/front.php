<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ceci est mon front</title>
        <meta name="description" content="Super site avec une magnifique intégration">
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/front.css">

    </head>
    <body>
            <!-- Navbar -->
    <div class="navbar">
        <a href="#">Accueil</a>
        <a href="#">Profil</a>
        
        <?php
        if (isset($pages) && !empty($pages)) {
            foreach ($pages as $page) {
                echo "<a href='/page/show?id={$page->getId()}'>{$page->getTitle()}</a>";
            }
        }
        ?>
        <a href="/security/logout">Déconnexion</a>
    </div>
        <h1>Template Front - CMS</h1>
        <!-- intégration de la vue -->
        <?php include "../Views/".$this->view.".php";?>
    </body>
</html>