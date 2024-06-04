
  <h1>Profile</h1>
  <p>Vous êtes connecté en tant que <?= htmlspecialchars($authUser->getLastname(), ENT_QUOTES, 'UTF-8') ?></p>
  <p>Prénom: <?= htmlspecialchars($authUser->getFirstname(), ENT_QUOTES, 'UTF-8') ?></p>
  <p>Nom: <?= htmlspecialchars($authUser->getLastname(), ENT_QUOTES, 'UTF-8') ?></p>
  <p>Email: <?= htmlspecialchars($authUser->getEmail(), ENT_QUOTES, 'UTF-8') ?></p>
  <p>session id: <?= htmlspecialchars($_SESSION['user_id'], ENT_QUOTES, 'UTF-8') ?></p>



