<section class="comment--wrapper">
    <h2>Page</h2>
    <ul>
          <section class="comment--wrapper__close">
                <div class="comment--wrapper__unit">
                    <div class="comment--infos">
                        <li class="comment--value">
                            <h3>Titre</h3>
                            <p><?= htmlspecialchars($page->getTitle(), ENT_QUOTES, 'UTF-8') ?></p>
                        </li>
                        <li class="comment--value">
                            <h3>Description</h3>
                            <p><?= htmlspecialchars($page->getDescription(), ENT_QUOTES, 'UTF-8') ?></p>
                        </li>
                        <li class="comment--value">
                            <h3>Contenu</h3>
                            <p><?= htmlspecialchars($page->getContent(), ENT_QUOTES, 'UTF-8') ?></p>
                        </li>
                    </div>
                </div>
               
            </section>
    </ul>
</section>
