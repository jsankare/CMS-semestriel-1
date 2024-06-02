<section class="article--wrapper">
    <h2>Menu articles</h2>
    <section class="article--navigation">
        <a href="/article/create"><img class="article--icon" src="/assets/add.svg" alt="Créer une article" ></a>
    </section>
    <ul>
        <?php if (!empty($articles)): ?>
            <?php
            usort($articles, function($a, $b) {
                return $a->getId() <=> $b->getId();
            });
            ?>
            <section class="article--wrapper__close" >
            <?php foreach ($articles as $article): ?>
            <div class="article--wrapper__unit" >
                <div class="article--infos" >
                    <li class="article--value">
                        <h3>Nom</h3><p><?php echo htmlspecialchars($article->getTitle()); ?></p>
                    </li>
                    <li class="article--value" >
                        <h3>Description</h3><p><?php echo htmlspecialchars($article->getDescription()); ?></p>
                    </li>
                </div>
                <div class="article--content">
                    <li class="article--value" >
                        <h3>Contenu</h3><p class="article--content__value" ><?php echo htmlspecialchars($article->getContent()); ?></p>
                    </li>
                </div>
                <a class="article--icon__link" href="/article/delete?id=<?php echo $article->getId(); ?>"><img class="article--icon article--icon__trash" src="/assets/trash.svg" ></a>
                <a class="article--icon__link" href="/article/edit?id=<?php echo $article->getId(); ?>"><img class="article--icon article--icon__update" src="/assets/update.svg" ></a>
                <a class="article--icon__link" href="/comment/add?article_id=<?php echo $article->getId(); ?>"><img class="article--icon article--icon__comment" src="/assets/comment.svg" alt="Commenter l'article"></a>
            </div>
            <?php endforeach; ?>
            </section>
        <?php else: ?>
            <li>Il n'y a pas d'article pour le moment !</li>
        <?php endif; ?>
    </ul>
</section>
