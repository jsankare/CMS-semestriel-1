<h1>Suppression d'utilisateur'</h1>

<h2>Attention !</h2>
<p>Vous vous appretez à supprimer l'utilisateur' <?= $user->getFirstName(). ' ' . $user->getLastName(); ?>, continuer ?</p>
<a href="/users/delete?id=<?php echo $user->getid(); ?>" >Je suis sûr de moi et je veux supprimer cet utilisateur</a>

<p>Vous serez ensuite redirigé vers les utilisateurs</p>