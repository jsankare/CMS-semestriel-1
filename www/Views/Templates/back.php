<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ceci est mon back</title>
        <meta name="description" content="Super site avec une magnifique intégration">
        <link rel="stylesheet" href="/css/back.css">
    </head>
    <body>
        <main class="mainBack" >
            <aside class="navbar" >
                <a href="/dashboard">dashboard</a>
                <h3>Barre de navigation</h3>
                <section>
                    <h4>Pages</h4>
                    <ul>
                        <li><a href="/page/create">Créer une page</a></li>
                    </ul>
                </section>
                <section>
                    <h4>Articles</h4>
                    <ul>
                        <li><a href="/article/create">Créer un article</a></li>
                    </ul>
                </section>
            </aside>
            <section class="content" >
                <h1>Template Back - CMS</h1>
                <!-- intégration de la vue -->
                <?php include "../Views/".$this->view.".php";?>
            </section>
        </main>
    </body>
</html>