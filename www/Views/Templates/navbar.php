<div class="navbar">
    <div class="navbar-logo">
        <a href="/"><img src="path/to/your/logo.png" alt="CMS Logo"></a>
    </div>
    
    <?php if ($_SERVER['REQUEST_URI'] == '/login' || $_SERVER['REQUEST_URI'] == '/register'): ?>
        <!-- Si l'utilisateur est sur la page de connexion ou de registre, ne rien afficher ici -->
    
    <?php elseif (!isset($_SESSION['user_id'])): ?>
        <?php if ($_SERVER['REQUEST_URI'] == '/home'): ?>
            <?php if (!empty($pages)): ?>
                <?php foreach ($pages as $page): ?>
                    <a href="/page/<?= htmlspecialchars($page->getSlug()) ?>"><?= htmlspecialchars($page->getTitle()) ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            <a href="/login">Se connecter</a>
        <?php else: ?>
            <a href="/">Accueil</a>
            <div class="dropdown">
                <button class="dropbtn">Pages</button>
                <div class="dropdown-content">
                    <?php if (!empty($pages)): ?>
                        <?php foreach ($pages as $page): ?>
                            <a href="/page/<?= htmlspecialchars($page->getSlug()) ?>"><?= htmlspecialchars($page->getTitle()) ?></a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <a href="/login" class="login">Se connecter</a>
            <a href="/register" class="register">S'inscrire</a>
        <?php endif; ?>
    <?php else: ?>
        <a href="/">Accueil</a>
        <a href="/profile">Profil</a>
        <div class="dropdown">
            <button class="dropbtn">Pages</button>
            <div class="dropdown-content">
                <?php if (!empty($pages)): ?>
                    <?php foreach ($pages as $page): ?>
                        <a href="/page/<?= htmlspecialchars($page->getSlug()) ?>"><?= htmlspecialchars($page->getTitle()) ?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <a href="/logout" class="logout">Déconnexion</a>
    <?php endif; ?>
</div>
