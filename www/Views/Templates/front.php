
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ceci est mon front</title>
        <meta name="description" content="Super site avec une magnifique intégration">
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/front.css">

    </head>
    <?php
    $setting = new \App\Models\Settings();
    $currentSetting = $setting->findOneById(1);
    $color = $currentSetting->getColor();
    ?>
    <body>
    <div class="navbar" style="background-color: <?php echo $color; ?>;">
        <a href="/">Accueil</a>
        <a href="/articles" >Articles</a>
        <a href="/gallery" >Galerie</a>
        <?php
        if (isset($pages) && !empty($pages)) {
            foreach ($pages as $page) {
                echo "<a href='/page/showPage?id={$page->getId()}'>{$page->getTitle()}</a>";
            }
        }
        ?>
        <?php if(isset($_SESSION['user_status']) && $_SESSION['user_status'] > 1) {
            echo '<a href="/logout" class="logout">Déconnexion</a>';
            echo '<a class="logout" href="/profile">Profil</a>';
            echo '<a href="/dashboard" class="logout">Dashboard</a>';
        } else {
            echo '<a href="/register" class="logout">Inscription</a>';
            echo '<a href="/login" class="logout">Connexion</a>';
        }; ?>
    </div>
        <!-- intégration de la vue -->
        <?php include "../Views/".$this->view.".php";?>
    </body>
</html>