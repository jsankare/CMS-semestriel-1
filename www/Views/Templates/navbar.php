<div class="navbar">
    <div class="navbar-logo">
        <a href="/"><img src="path/to/your/logo.png" alt="CMS Logo"></a>
    </div>

    <?php if ($_SERVER['REQUEST_URI'] == '/login'): ?>
        <!-- Si l'utilisateur est sur la page de connexion, ne rien afficher ici -->
    <?php elseif (!isset($_SESSION['user_id'])): ?>
        <!-- Si l'utilisateur n'est pas connecté -->
        <a href="/">Accueil</a>
        <div class="dropdown">
            <button class="dropbtn">Pages</button>
            <div class="dropdown-content">
                <?php if (!empty($pages)): ?>
                    <?php foreach ($pages as $page): ?>
                        <a href="/page/<?= $page->getSlug() ?>"><?= htmlspecialchars($page->getTitle()) ?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <a href="/login" class="login">Se connecter</a>
        <a href="/register" class="register">S'inscrire</a>
    <?php else: ?>
        <!-- Si l'utilisateur est connecté -->
        <a href="/">Accueil</a>
        <a href="/profile">Profil</a>
        <div class="dropdown">
            <button class="dropbtn">Pages</button>
            <div class="dropdown-content">
                <?php if (!empty($pages)): ?>
                    <?php foreach ($pages as $page): ?>
                        <a href="/page/<?= $page->getSlug() ?>"><?= htmlspecialchars($page->getTitle()) ?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <a href="/logout" class="logout">Déconnexion</a>
    <?php endif; ?>
</div>
