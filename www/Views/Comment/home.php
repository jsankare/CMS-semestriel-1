<section class="article--wrapper">
    <h2>Menu des commentaires</h2>
    <section class="article--navigation">
        <a href="/article/home"><img class="article--icon" src="/assets/add.svg" alt="Mettre un commentaire" ></a>
    </section>
    <ul>
        <?php if (!empty($comments)): ?>
            <?php
            usort($comments, function($a, $b) {
                return $a->getId() <=> $b->getId();
            });
            ?>
            <section class="article--wrapper__close">
                <?php foreach ($comments as $comment): ?>
                <div class="article--wrapper__unit">
                    <div class="article--infos">
                        <li class="article--value">
                            <h3>Article</h3>
                            <p><?php echo htmlspecialchars($comment->getTitle()); ?></p>
                        </li>
                        <li class="article--value">
                            <h3>Commentaire</h3>
                            <p><?php echo htmlspecialchars($comment->getContent()); ?></p>
                        </li>
                        <li class="article--value">
                            <h3>Status</h3>
                            <p><?php echo htmlspecialchars($comment->getStatus()); ?></p>
                        </li>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <li>Il n'y a pas de commentaires pour le moment !</li>
        <?php endif; ?>
    </ul>
</section>
