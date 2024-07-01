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
                            <h3>Status</h3>
                            <?php if($comment->getStatus() == 0): ?>
                            <p>Non validé</p>
                            <?php else: ?>
                            <p>validé</p>
                            <?php endif ?>
                        </li>
                        <li class="comment--item">
                                <h3>Modérer</h3>
                                <p><a href="/comment/moderate?id=<?= $comment->getId(); ?>">Changer</a></p>
                            </li>
                        <li class="comment--value comment--value__icon">
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
