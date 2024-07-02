<?php

namespace App;

use App\Core\Security;

session_start(); // Débute la session, toujours en haut du fichier

require '../vendor/autoload.php';
require '../config/envLoader.php';

// Charger les variables d'environnement
loadEnv(__DIR__ . '/../.env');

//Notre Autoloader
spl_autoload_register("App\myAutoloader");

function myAutoloader($class){
    $classExploded = explode("\\", $class);
    $class = end($classExploded);
    //echo "L'autoloader se lance pour ".$class;
    if(file_exists("../Core/".$class.".php")){
        include "../Core/".$class.".php";
    }
    if(file_exists("../Models/".$class.".php")){
        include "../Models/".$class.".php";
    }
}

if (!file_exists('../config/config.php')) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $db_host = $_POST['db_host'];
        $db_name = $_POST['db_name'];
        $db_user = $_POST['db_user'];
        $db_pass = $_POST['db_pass'];
        $siteName = $_POST['siteName'];
        $siteDescription = $_POST['siteDescription'];

        $config_content = "<?php\n";
        $config_content .= "define('DB_HOST', '$db_host');\n";
        $config_content .= "define('DB_NAME', '$db_name');\n";
        $config_content .= "define('DB_USER', '$db_user');\n";
        $config_content .= "define('DB_PASS', '$db_pass');\n";
        $config_content .= "define('SITE_NAME', '$siteName');\n";
        $config_content .= "define('SITE_DESCRIPTION', '$siteDescription');\n";

        if (file_put_contents('../config/config.php', $config_content)) {
            echo 'Le fichier de configuration a été créé avec succès.';
        } else {
            echo 'Une erreur est survenue lors de la création du fichier de configuration.';
        }
        exit;
    } else {
        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <title>Installation</title>
        </head>
        <body>
        <h1>Installation</h1>
        <form method="POST" action="">
            <label for="db_host">Hôte de la base de données :</label>
            <input type="text" id="db_host" name="db_host" required><br>

            <label for="db_name">Nom de la base de données :</label>
            <input type="text" id="db_name" name="db_name" required><br>

            <label for="db_user">Utilisateur de la base de données :</label>
            <input type="text" id="db_user" name="db_user" required><br>

            <label for="db_pass">Mot de passe de la base de données :</label>
            <input type="password" id="db_pass" name="db_pass" required><br>

            <label for="siteName">Le nom de votre site :</label>
            <input type="text" id="sitename" name="siteName" required><br>

            <label for="siteDescription">Une description de votre site :</label>
            <input type="text" id="siteDescription" name="siteDescription" required><br>

            <input type="submit" value="Installer">
        </form>
        </body>
        </html>

        <?php
        exit;
    }
}

require_once ("../config/config.php");

// Function to map URI slug to route
function mapSlugToRoute($uri, $routes) {
    foreach ($routes as $route => $data) {
        $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $route);
        if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
            array_shift($matches);
            return [$route, $matches];
        }
    }
    return [null, []];
}

$uri = $_SERVER["REQUEST_URI"];
if(strlen($uri) > 1)
    $uri = rtrim($uri, "/");
$uriExploded = explode("?",$uri);
$uri = $uriExploded[0];

$listOfRoutes = [];
if (file_exists("../Routes.yml")) {
    $listOfRoutes = yaml_parse_file("../Routes.yml");
} else {
    header("Internal Server Error", true, 500);
    header('Location: /500');
    exit();
}

list($requestedRoute, $params) = mapSlugToRoute($uri, $listOfRoutes);

if (!$requestedRoute || empty($listOfRoutes[$requestedRoute])) {
    header("Status 404 Not Found", true, 404);
    header('Location: /404');
    exit();
}

if (!$requestedRoute || empty($listOfRoutes[$requestedRoute])) {
    header("Status 404 Not Found", true, 404);
    header('Location: /404');
    exit();
}

$controller = $listOfRoutes[$requestedRoute]["Controller"];
$action = $listOfRoutes[$requestedRoute]["Action"];
$role = $listOfRoutes[$requestedRoute]["Role"];
$isProtected = $listOfRoutes[$requestedRoute]["Security"];

// instantiate Core/security
$securityGuard = new Security();

if($isProtected && !$securityGuard->isLogged()) {
    header("UNAUTHORIZED", true, 401);
    // echo 'Vous devez être connecté pour voir cette page';
    header('Location: /401');
    exit();
}

// Conversion pour comparaison dans mon Core/Security
$roleHierarchy = [
    'Guest' => 0,
    'User' => 1,
    'Editor' => 2,
    'Moderator' => 3,
    'Admin' => 4,
];
$requiredRole = $roleHierarchy[$role];

// check si l'user actuel a un role suffisant
if ($isProtected && !$securityGuard->hasRole($requiredRole)) {
    header("UNAUTHORIZED", true, 401);
    // echo 'Vous devez être connecté pour voir cette page';
    header('Location: /401');
    exit();
}

// include controller file
if (!file_exists("../Controllers/".$controller.".php")) {
    header("Not Implemented", true, 501);
    header('Location: /501');
}
include "../Controllers/".$controller.".php";

$controller = "App\\Controller\\".$controller;

if (!class_exists($controller)) {
    header("Not Implemented", true, 501);
    header('Location: /501');
}
$objetController = new $controller();

if (!method_exists($objetController, $action)) {
    header("Not Implemented", true, 501);
    header('Location: /501');
}

$objetController->$action(...$params);
