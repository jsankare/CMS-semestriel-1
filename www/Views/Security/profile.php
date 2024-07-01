<main class="profile">
    <h1 class="profile--title">Bienvenue sur votre profil, <?= htmlspecialchars($authenticatedUser->getFirstname(), ENT_QUOTES, 'UTF-8') ?></h1>
    <section class="profile--content">
        <section class="profile--statistics">
            <h2>Statistiques de votre profil</h2>
            <div>
                <?php if (empty($userComments)): ?>
                    <h3>Vous n'avez pas encore commenté d'article pour le moment</h3>
                <?php else: ?>
                    <h3>Voici la liste des articles que vous avez commentés</h3>
                    <ul>
                        <?php foreach ($userComments as $comment): ?>
                        <?php if ($comment['status'] == 1): ?>
                            <li>
                                <strong><?= htmlspecialchars($comment['article_title'], ENT_QUOTES, 'UTF-8') ?></strong> le <?= htmlspecialchars($comment['formatted_date'], ENT_QUOTES, 'UTF-8') ?>
                                <?= htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8') ?>
                            </li>
                        <?php endif ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>
        <section class="profile--update">
            <div class="profile--update__form">
                <h2>Pour modifier vos informations</h2>
                <?= $updateProfileForm ?>
                <section class="profile--update__dangerZone">
                    <h3>Attention, zone de danger !</h3>
                    <div class="profile--update__danger">
                        <h4>Pour recevoir un mail de modification de mot de passe <a href="/sendResetPassword?id=<?= $authenticatedUser->getId(); ?>">cliquez ici</a></h4>
                        <span>Attention, le mail est à usage unique et expire après 12 heures.</span>
                    </div>
                    <div class="profile--update__danger">
                        <h4>Pour supprimer votre compte <a href="/profile/predelete?id=<?= $authenticatedUser->getId(); ?>">cliquez ici</a></h4>
                        <span>Attention, toute suppression de compte est définitive</span>
                    </div>
                </section>
            </div>
        </section>
    </section>
</main>
