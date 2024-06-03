<section class="dashboard">
    <h2 class="dashboard--title" >Bienvenue sur le Dashboard</h2>
    <section class="dashboard--content" >
        <section class="dashboard--statistics" >
            <h2>Statistiques du CMS :</h2>
            <p>charts ici</p>
        </section>
        <h2>Liste des contenus</h2>
        <section class="dashboard--matter" >
            <section class="dashboard--content__main">
                <h3 class="dashboard--title dashboard--title__content" >Les pages :</h3>
                <?php if (!empty($pages)) : ?>
                    <ul>
                        <?php foreach ($pages as $page) : ?>
                            <li>Page : <?php echo htmlspecialchars($page->getTitle()); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>Aucune page disponible</p>
                <?php endif; ?>
                <h3 class="dashboard--title dashboard--title__content" >Les articles :</h3>
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
            <aside class="dashboard--content__aside">
                <h3 class="dashboard--title" >Liste des utilisateurs</h3>
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
    </section>
</section>

