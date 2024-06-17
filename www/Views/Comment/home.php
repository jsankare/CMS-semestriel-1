<section class="comment--wrapper">
    <h2>Menu des commentaires</h2>
    <ul>
        <?php if (!empty($comments)): ?>
            <?php
            usort($comments, function($a, $b) {
                return $a->getId() <=> $b->getId();
            });
            ?>
            <section class="comment--wrapper__close">
                <?php foreach ($comments as $comment): ?>
                <div class="comment--wrapper__unit">
                    <div class="comment--infos">
                        <li class="comment--value">
                            <h3>Auteur </h3>
                            <p><?php echo $comment->getUserName(); ?></p>
                        </li>
                        <li class="comment--value">
                            <h3>Article</h3>
                            <p><?php echo $comment->getTitle(); ?></p>
                        </li>
                        <li class="comment--value">
                            <h3>date </h3>
                            <p><?= htmlspecialchars($comment->getFormattedDate()); ?></p>
                        </li>
                        <li class="comment--value">
                            <h3>Commentaire</h3>
                            <p><?php echo $comment->getContent(); ?></p>
                        </li>
                        <li class="comment--value">
                            <a class="comment--icon__link" href="/comment/delete?id=<?php echo $comment->getId(); ?>">
                                <img class="comment--icon comment--icon__trash" src="/assets/trash.svg" >
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
