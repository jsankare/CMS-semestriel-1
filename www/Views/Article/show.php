<!-- src/Views/article/show.php -->
<main class="article">
    <h1>Les articles</h1>
    <section class="article--section">
        <?php foreach ($articles as $article): ?>
            <article class="article--wrapped">
                <h3 class="article--wrapped__title"><?= $article->getTitle(); ?> :</h3>
                <p class="article--wrapped__content"><?= $article->getContent(); ?></p>
                <?php if (isset($_SESSION['user_id'])) { ?>
                <div>
                    <h5>Laisser un commentaire</h5>
                    <form class="article--comment__form" action="/comment/create" method="post">
                        <input type="hidden" name="article_id" value="<?= $article->getId(); ?>">
                        <textarea name="content" placeholder="Votre commentaire" required></textarea>
                        <button type="submit">Envoyer</button>
                    </form>
                </div>
                <?php } ?>
                <section class="article--wrapped__comments">
                    <?php if ($article->comments): ?>
                        <h4>Commentaires</h4>
                        <?php foreach ($article->comments as $comment): ?>
                            <div class="article--commentSection">
                                <p>Par <strong><?= $comment->getUserName(); ?></strong> le <?= $comment->getFormattedDate(); ?></p>
                                <p><?= $comment->getContent(); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h4>Cet article n'a pas de commentaire pour le moment</h4>
                    <?php endif; ?>
                </section>
            </article>
        <?php endforeach; ?>
    </section>
</main>
