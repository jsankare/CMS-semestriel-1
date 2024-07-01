<?php if (isset($article) && isset($comments)): ?>
    <section class="comment--container">
        <h2>Commentaires pour l'article: <?= htmlspecialchars($article->getTitle()); ?></h2>
        <ul>
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment--container__global">
                        <div class="comment--container__wrapper">
                            <li class="comment--item">
                                <h3>Auteur</h3>
                                <p><?= htmlspecialchars($comment->getUserName()); ?></p>
                            </li>
                            <li class="comment--item">
                                <h3>Date</h3>
                                <p><?= htmlspecialchars($comment->getFormattedDate()); ?></p>
                            </li>
                            <li class="comment--item">
                                <h3>Commentaire</h3>
                                <p><?= htmlspecialchars($comment->getContent()); ?></p>
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
                            <li class="comment--item">
                                <a class="comment--icon__link" href="/comment/delete?id=<?= $comment->getId(); ?>">
                                    <img class="comment--icon comment--icon__trash" src="/assets/trash.svg">
                                </a>
                            </li>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Il n'y a pas de commentaires pour cet article.</li>
            <?php endif; ?>
        </ul>
    </section>
<?php else: ?>
    <p>Erreur lors de la récupération des commentaires.</p>
<?php endif; ?>
