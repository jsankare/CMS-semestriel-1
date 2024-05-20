<h1>Profil de l'utilisateur</h1>
<p>Prénom: <?= htmlspecialchars($user->getFirstname(), ENT_QUOTES, 'UTF-8') ?></p>
<p>Nom: <?= htmlspecialchars($user->getLastname(), ENT_QUOTES, 'UTF-8') ?></p>
<p>Email: <?= htmlspecialchars($user->getEmail(), ENT_QUOTES, 'UTF-8') ?></p>
