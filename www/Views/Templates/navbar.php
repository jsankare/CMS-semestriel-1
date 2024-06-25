<div class="navbar">
    <div class="navbar-logo">
        <a href="/"><img src="path/to/your/logo.png" alt="CMS Logo"></a>
    </div>
    
    <?php if ($_SERVER['REQUEST_URI'] == '/login' || $_SERVER['REQUEST_URI'] == '/register'): ?>
        <!-- Si l'utilisateur est sur la page de connexion ou de registre, ne rien afficher ici -->
    
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
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="/login" class="login">Se connecter</a>
            <a href="/register" class="register">S'inscrire</a>
        <?php else: ?>
            <a href="/profile">Profil</a>
            <a href="/logout" class="logout">Déconnexion</a>
        <?php endif; ?>
    <?php endif; ?>
</div>
