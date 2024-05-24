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
                <a class="navbar--logo__link" href="/dashboard">
                    <img class="navbar--logo__picture" src="/assets/logo.svg">
                </a>
                <h3>Navigation</h3>
                <section>
                    <h4>Dashboard</h4>
                    <ul class="navbar--list navbar--list__dashboard">
                        <li class="navbar--list__line"><a href="/dashboard">Aller au dashboard</a></li>
                    </ul>
                </section>
                <section>
                    <h4>Pages</h4>
                    <ul class="navbar--list navbar--list__pages">
                        <li class="navbar--list__line"><a href="/page/create">Créer une page</a></li>
                    </ul>
                </section>
                <section>
                    <h4>Articles</h4>
                    <ul class="navbar--list navbar--list__articles">
                        <li class="navbar--list__line"><a href="/article/create">Créer un article</a></li>
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