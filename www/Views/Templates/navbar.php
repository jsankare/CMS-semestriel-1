<div class="navbar" style="background-color: <?= $backgroundColor ?? ''; ?>; font-family: <?= $fontStyle ?? ''; ?>">
    <?php if ($_SERVER['REQUEST_URI'] != '/login' && $_SERVER['REQUEST_URI'] != '/register'): ?>
        <div class="navbar-logo">
            <a href="/"><img src="path/to/your/logo.png" alt="CMS Logo"></a>
        </div>
    <?php endif; ?>
    
    <a href="/">Accueil</a>
    <a href="/articles">Articles</a>
    <a href="/gallery">Galerie</a>

    <?php if (isset($pages) && !empty($pages)): ?>
        <div class="dropdown">
            <button class="dropbtn">Pages</button>
            <div class="dropdown-content">
                <?php foreach ($pages as $page): ?>
                    <?php if (!$page->getIsMain()): ?>
                            <a href="/page/<?= htmlspecialchars($page->getSlug()) ?>"><?= htmlspecialchars($page->getTitle()) ?></a>
                        <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_status']) && $_SESSION['user_status'] > 1): ?>
        <a href="/logout" class="logout">Déconnexion</a>
        <a href="/profile" class="logout">Profil</a>
        <a href="/dashboard" class="logout">Dashboard</a>
    <?php else: ?>
        <a href="/register" class="logout">Inscription</a>
        <a href="/login" class="logout">Connexion</a>
    <?php endif; ?>
</div>
