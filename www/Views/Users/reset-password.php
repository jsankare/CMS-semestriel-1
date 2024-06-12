<h1>Réinitialisation de mot de passe</h1>

<h2>Attention !</h2>
<p>Voulez-vous envoyer un mail de réinitialisation de mot de passe pour <?= $user->getFirstName(). ' ' . $user->getLastName(); ?> ?</p>
<a href="/sendResetPassword?id=<?php echo $user->getid(); ?>" >Envoyer le lien</a>

<p>Vous serez ensuite redirigé sur la page d'édition de l'utilisateur</p>