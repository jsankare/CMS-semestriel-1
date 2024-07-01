<h1>Suppression d'article</h1>

<h2>Attention !</h2>
<p>Vous vous appretez à supprimer l'article <?= $article->getTitle()?> ainsi que tous ses commentaires, cette action est définitive, continuer ?</p>
<a href="/article/delete?id=<?php echo $article->getid(); ?>" >Je suis sûr de moi et je veux supprimer l'article</a>

<p>Vous serez ensuite redirigé vers les articles</p>