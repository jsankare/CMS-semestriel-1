<h1>Suppression de votre compte</h1>

<h2>Attention <?= $user->getFirstname()?> <?= $user->getLastname()?> !</h2>
<p>Vous vous appretez à supprimer votre compte, continuer ?</p>
<a href="/profile/delete?id=<?php echo $user->getid(); ?>" >Je suis sûr de moi et je veux supprimer mon compte</a>

<p>Vous serez ensuite redirigé vers la page d'accueil</p>