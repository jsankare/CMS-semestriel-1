<h1>Profil de l'utilisateur</h1>
<p>Prénom: <?= htmlspecialchars($authUser->getFirstname(), ENT_QUOTES, 'UTF-8') ?></p>
<p>Nom: <?= htmlspecialchars($authUser->getLastname(), ENT_QUOTES, 'UTF-8') ?></p>
<p>Email: <?= htmlspecialchars($authUser->getEmail(), ENT_QUOTES, 'UTF-8') ?></p

<?= $form ?>
