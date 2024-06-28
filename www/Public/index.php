<?php

namespace App;

use App\Core\Security;

session_start();

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
    die("Le fichier de routing ../Routes.yml n'existe pas");
}

list($requestedRoute, $params) = mapSlugToRoute($uri, $listOfRoutes);

if (!$requestedRoute || empty($listOfRoutes[$requestedRoute])) {
    header("Status 404 Not Found", true, 404);
    echo "Page 404 : Aucune route trouvée pour l'URI '$uri'";
    echo "<br>Liste des routes disponibles :<br>";
    foreach ($listOfRoutes as $route => $data) {
        echo "- $route<br>";
    }
    die();
}

$controller = $listOfRoutes[$requestedRoute]["Controller"];
$action = $listOfRoutes[$requestedRoute]["Action"];
$role = $listOfRoutes[$requestedRoute]["Role"];
$isProtected = $listOfRoutes[$requestedRoute]["Security"];

// instantiate Core/security
$securityGuard = new Security();

if($isProtected && !$securityGuard->isLogged()) {
    echo 'Vous devez être connecté pour voir cette page';
    die();
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
    echo 'Vous n\'avez pas les permissions nécessaires pour voir cette page';
    die();
}

// include controller file
if (!file_exists("../Controllers/".$controller.".php")) {
    die("Le fichier controller ../Controllers/".$controller.".php n'existe pas");
}
include "../Controllers/".$controller.".php";

$controller = "App\\Controller\\".$controller;

if (!class_exists($controller)) {
    die("La classe controller ".$controller." n'existe pas");
}

$objetController = new $controller();

if (!method_exists($objetController, $action)) {
    die("L'action ".$action." n'existe pas dans le controller ".$controller);
}

$objetController->$action(...$params);
