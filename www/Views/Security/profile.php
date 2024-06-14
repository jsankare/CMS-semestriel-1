<main class="profile">
    <h1 class="profile--title">Bienvenue sur votre profil, <?= htmlspecialchars($authenticatedUser->getFirstname(), ENT_QUOTES, 'UTF-8') ?></h1>
    <section class="profile--content">
        <section class="profile--statistics">
            <h2>Statistiques de votre profil</h2>
            <div>
                <h3>Voici la liste des articles que vous avez commentés</h3>
                <ul>
                    <?php

                    ?>
                </ul>
            </div>
        </section>
        <section class="profile--update">
            <h2>Pour modifier vos informations</h2>
            <?= $updateProfileForm ?>
            <h4>Pour recevoir un mail de modification de mot de passe <a href="#" alt="reset password link">cliquez ici</a></h4>
            <span>Attention, le mail est à usage unique et expire après 12heures.</span>
        </section>
    </section>
<!--    <aside class="profile--aside">-->
<!--        <a href="/dashboard" >dashboard</a>-->
<!--    </aside>-->
</main>




