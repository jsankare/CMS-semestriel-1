<section class="dashboard">
    <h2>Hello Dashboard</h2>
    <section class="dashboard--main">
        <p>main :</p>
    </section>
    <aside class="dashboard--aside">
        <p>aside</p>
        <?php if (!empty($pages)) : ?>
            <ul>
                <?php foreach ($pages as $page) : ?>
                    <li>Page : <?php echo htmlspecialchars($page->getTitle()); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Aucune page disponible</p>
        <?php endif; ?>
    </aside>
</section>

