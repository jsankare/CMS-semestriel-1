<section class="article--wrapper">
    <h2>Menu des commentaires</h2>
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
                            <h3>Auteur ID</h3>
                            <p><?php echo $comment->getUserId(); ?></p>
                        </li>
                        <li class="article--value">
                            <h3>Article</h3>
                            <p><?php echo htmlspecialchars($comment->getTitle()); ?></p>
                        </li>
                        <li class="article--value">
                            <h3>Commentaire</h3>
                            <p><?php echo htmlspecialchars($comment->getContent()); ?></p>
                        </li>
                        <li class="article--value">
                            <a class="article--icon__link" href="/article/delete?id=<?php echo $comment->getId(); ?>">
                                <img class="article--icon article--icon__trash" src="/assets/trash.svg" >
                            </a>
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
