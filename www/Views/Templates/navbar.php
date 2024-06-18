
<div class="navbar">
    <div class="navbar-logo">
        <a href="index.php"><img src="path/to/your/logo.png" alt="CMS Logo"></a>
    </div>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <?php if ($_SERVER['REQUEST_URI'] == '/home'): ?>
            
            <?php
            if (isset($pages) && !empty($pages)) {
                foreach ($pages as $page) {
                  echo "<a href='/page/{$page->getSlug()}/{$page->getId()}'>{$page->getTitle()}</a>";
                }
            }
            ?>
            <a href="/login">Se connecter</a>
        <?php elseif ($_SERVER['REQUEST_URI'] == '/login'): ?>
           
        <?php else: ?>
           
            <a href="/home">Accueil</a>
            <a href="/login">Se connecter</a>
        <?php endif; ?>
    <?php else: ?>
        <!-- Navbar for connected users -->
        <a href="/">Accueil</a>
        <a href="/profile">Profil</a>
        <div class="dropdown">
            <button class="dropbtn">Pages</button>
            <div class="dropdown-content">
                <?php
                if (isset($pages) && !empty($pages)) {
                    foreach ($pages as $page) {
                        echo "<a href='/page/{$page->getSlug()}/{$page->getId()}'>{$page->getTitle()}</a>";
                    }
                }
                ?>
            </div>
        </div>
        <a href="/logout" class="logout">Déconnexion</a>
    <?php endif; ?>
</div>
