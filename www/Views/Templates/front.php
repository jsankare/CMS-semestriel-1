
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
    <?php if (isset($_SESSION['user_id'])): ?>
    
    <div class="navbar">
        <div class="navbar-logo">
            <a href="index.php"><img src="logo.png" alt="CMS Logo"></a>
        </div>
        <a href="#">Accueil</a>
        <a href="/profile">Profil</a>
        <div class="dropdown">
            <button class="dropbtn">Pages
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
            <?php
                if (isset($pages) && !empty($pages)) {
                    foreach ($pages as $page) {
                        echo "<a href='/page/showPage?id={$page->getId()}'>{$page->getTitle()}</a>";
                    }
                }
            ?>
            </div>
        </div>
        <a href="/logout" class="logout">Déconnexion</a>
    </div>
    <?php endif; ?>

        <?php include 'navbar.php'; ?>

        <h1>Template Front - CMS</h1>

        <?php include "../Views/".$this->view.".php";?>
    </main>
    </body>
</html>