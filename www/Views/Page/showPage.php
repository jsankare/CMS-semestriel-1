<section class="comment--wrapper">
    <h2>Commentaire</h2>
    <section class="comment--navigation">
        <a href="/article/home"><img class="comment--icon" src="/assets/add.svg" alt="Mettre un commentaire" ></a>
    </section>
    <ul>
          <section class="comment--wrapper__close">
                <div class="comment--wrapper__unit">
                    <div class="comment--infos">
                        <li class="comment--value">
                            <h3>Article</h3>
                            <p><?= htmlspecialchars($page->getTitle(), ENT_QUOTES, 'UTF-8') ?></p>
                        </li>
                        <li class="comment--value">
                            <h3>Commentaire</h3>
                            <p><?= htmlspecialchars($page->getContent(), ENT_QUOTES, 'UTF-8') ?></p>
                        </li>
                    </div>
                </div>
               
            </section>
    </ul>
</section>
