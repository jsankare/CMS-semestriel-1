<section class="dashboard">
    <h2>Hello Dashboard</h2>
    <section class="dashboard--main">
        <p>main :</p>
        <?php if (!empty($pages)) : ?>
            <ul>
                <?php foreach ($pages as $page) : ?>
                    <li>Page : <?php echo htmlspecialchars($page->getTitle()); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Aucune page disponible</p>
        <?php endif; ?>
        <?php if (!empty($articles)) : ?>
            <ul>
                <?php foreach ($articles as $article) : ?>
                    <li>Article <?php echo $article->getId(); ?>: <?php echo htmlspecialchars($article->getTitle()); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Aucun article disponible</p>
        <?php endif; ?>
    </section>
    <aside class="dashboard--aside">
        <p>aside :</p>
        <?php if (!empty($users)) : ?>
            <ul>
                <?php foreach ($users as $user) : ?>
                    <li>ID Utilisateur: <?php echo $user->getId(); ?></li>
                    <li>Prénom <?php echo htmlspecialchars($user->getFirstname()); ?></li>
                    <li>Nom <?php echo htmlspecialchars($user->getLastname()); ?></li>
                    <br>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Aucun utilisateur disponible</p>
        <?php endif; ?>
    </aside>
</section>

