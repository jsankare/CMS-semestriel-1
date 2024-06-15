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
                            <li>
                                <strong><?= htmlspecialchars($comment['article_title'], ENT_QUOTES, 'UTF-8') ?>:</strong>
                                <?= htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8') ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>
        <section class="profile--update">
            <h2>Pour modifier vos informations</h2>
            <?= $updateProfileForm ?>
            <h4>Pour recevoir un mail de modification de mot de passe <a href="#" alt="reset password link">cliquez ici</a></h4>
            <span>Attention, le mail est à usage unique et expire après 12heures.</span>
            <a href="/dashboard" >dashboard</a>
        </section>
    </section>
</main>
