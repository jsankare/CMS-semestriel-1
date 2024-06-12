
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
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="navbar">
        <a href="/profile">Accueil</a>
        <a href="/profile">Profil</a>
        
        <?php
        if (isset($pages) && !empty($pages)) {
            foreach ($pages as $page) {
                echo "<a href='/page/showPage?id={$page->getId()}'>{$page->getTitle()}</a>";
            }
        }
        ?>
        <a href="/logout" class="logout">Déconnexion</a>
    </div>
    <?php endif; ?>
        <h1>Template Front - CMS</h1>
        <!-- intégration de la vue -->
        <?php include "../Views/".$this->view.".php";?>
    </body>
</html>