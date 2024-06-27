
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ceci est mon front</title>
        <meta name="description" content="Super site avec une magnifique intégration">
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/front.css">

    </head>
    <body>

        <?php include 'navbar.php'; ?>

        <h1>Template Front - CMS</h1>

        <?php include "../Views/".$this->view.".php";?>
    </main>
    </body>
</html>