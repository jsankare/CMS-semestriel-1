<section class="article--wrapper">
    <h2>Commentaire</h2>
    <ul>
          <section class="article--wrapper__close">
                <div class="article--wrapper__unit">
                    <div class="article--infos">
                        <li class="article--value">
                            <h3>Article</h3>
                            <p><?= htmlspecialchars($page->getTitle(), ENT_QUOTES, 'UTF-8') ?></p>
                        </li>
                        <li class="article--value">
                            <h3>Commentaire</h3>
                            <p><?= htmlspecialchars($page->getContent(), ENT_QUOTES, 'UTF-8') ?></p>
                        </li>
                    </div>
                </div>
               
            </section>
    </ul>
</section>
