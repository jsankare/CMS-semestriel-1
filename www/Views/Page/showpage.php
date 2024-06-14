<section class="page--wrapper">
    <h2>Page</h2>
    <ul>
          <section class="page--wrapper__close">
                <div class="page--wrapper__unit">
                    <div class="page--infos">
                        <li class="page--value">
                            <h3>Titre</h3>
                            <p><?= htmlspecialchars($page->getTitle(), ENT_QUOTES, 'UTF-8') ?></p>
                        </li>
                        <li class="page--value">
                            <h3>Contenu</h3>
                            <p><?= strip_tags($page->getContent(), '<p><a><b><i><strong><em><ul><ol><li><br><h1><h2><h3><h4><h5><h6>') ?></p>
                        </li>
                    </div>
                </div>
               
            </section>
    </ul>
</section>
