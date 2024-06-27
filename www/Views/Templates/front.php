
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
    if($setting->findOneById(1)) {
        $currentSetting = $setting->findOneById(1);
        $backgroundColor = $currentSetting->getBackgroundColor();
        $fontColor = $currentSetting->getFontColor();
        $fontStyle = $currentSetting->getFontStyle();
    } else {
        $backgroundColor = $_ENV["BACKGROUND_COLOR"];
        $fontColor = $_ENV["FONT_COLOR"];
        $fontStyle = $_ENV["FONT_STYLE"];
    }
    ?>
    <body>
    <div class="navbar" style="background-color: <?= $backgroundColor ?>;">
        <ul>
            <li><a style="color: <?= $fontColor ?>;" href="/">Accueil</a></li>
            <li><a style="color: <?= $fontColor ?>;" href="/articles" >Articles</a></li>
            <li><a style="color: <?= $fontColor ?>;" href="/gallery" >Galerie</a></li>
        <?php
        if (isset($pages) && !empty($pages)) {
            foreach ($pages as $page) {
                echo "<li><a style='color: " . $fontColor . ";' href='/page/showPage?id=" . $page->getId() . "'>" . $page->getTitle() . "</a></li>";
            }
        }
        ?>
        <?php if (isset($_SESSION['user_status']) && $_SESSION['user_status'] > 1) {
            echo '<li><a href="/logout" class="logout" style="color: ' . $fontColor . '">Déconnexion</a></li>';
            echo '<li><a href="/profile" class="logout" style="color: ' . $fontColor . '">Profil</a></li>';
            echo '<li><a href="/dashboard" class="logout" style="color: ' . $fontColor . '">Dashboard</a></li>';
        } else {
            echo '<li><a href="/register" class="logout" style="color: ' . $fontColor . '">Inscription</a></li>';
            echo '<li><a href="/login" class="logout" style="color: ' . $fontColor . '">Connexion</a></li>';
        }
        ?>
        </ul>
    </div>
        <!-- intégration de la vue -->
        <?php include "../Views/".$this->view.".php";?>
    </body>
</html>