<section class="page--wrapper">
    <h2>Menu pages</h2>
    <section class="page--navigation">
        <a href="/page/create"><img class="page--icon" src="/assets/add.svg" alt="Créer une page" ></a>
    </section>
    <ul>
        <?php if (!empty($pages)): ?>
            <section class="page--wrapper__close" >
            <?php foreach ($pages as $page): ?>
            <div class="page--wrapper__unit" >
                <li>
                    <h3>Nom de page</h3><p><?php echo htmlspecialchars($page->getTitle()); ?></p>
                </li>
                <li>
                    <h3>Description de page</h3><p><?php echo htmlspecialchars($page->getContent()); ?></p>
                </li>
                <img class="page--icon page--icon__trash" src="/assets/trash.svg" >
            </div>
            <?php endforeach; ?>
            </section>
        <?php else: ?>
            <li>Il n'y a pas de page pour le moment !</li>
        <?php endif; ?>
    </ul>
</section>
