<?php

namespace App;

use App\Core\Security;

session_start(); 

require '../vendor/autoload.php';
require '../config/envLoader.php';

loadEnv(__DIR__ . '/../.env');

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

//Lorsque on met dans l'url /login par exemple
//On récupère dans le fichier Routes.yaml le controller et l'action associée
//On fait une instance du controller ex: $controller = new Security();
//Et on appelle l'action associée ex : $controller->login();
//Si je décide de remplacer dans le fichier routes.yaml /login par /se-connecter tout doit fonctionner
//Attention pensez à effectuer un maximum de vérification et d'afficher les erreurs s'il y en a, exemple le fichier Routes.yaml n'existe pas
// ou autre exemple le controller Security ne possède pas d'acion login
//Le résultat final dans notre exemple doit afficher "Se connecter" dans le navigateur ou alors afficher PAGE 404
//Consigne du TP : Envoyer par mail : y.skrzypczyk@gmail.com
//Objet du mail : "Projet TP ROUTING - GROUPE X"
//Contenu du mail copier coller le contenu du fichier index.php et la liste des membres du groupe
//A envoyer avant 13 le 01/03/2024-

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

$securityGuard = new Security();

$isProtected = $listOfRoutes[$requestedRoute]["Security"];
if ($isProtected && !$securityGuard->isLogged()) {
    echo 'Vous devez être connecté pour voir cette page';
    die();
}

$role = $listOfRoutes[$requestedRoute]["Role"];
$roleHierarchy = [
    'Guest' => 0,
    'User' => 1,
    'Editor' => 2,
    'Moderator' => 3,
    'Admin' => 4,
];
$requiredRole = $roleHierarchy[$role];

if ($isProtected && !$securityGuard->hasRole($requiredRole)) {
    echo 'Vous n\'avez pas les permissions nécessaires pour voir cette page';
    die();
}

$controller = $listOfRoutes[$requestedRoute]["Controller"];
$action = $listOfRoutes[$requestedRoute]["Action"];

if (!file_exists("../Controllers/".$controller.".php")) {
    die("Le fichier controller ../Controllers/".$controller.".php n'existe pas");
}
include "../Controllers/".$controller.".php";

$controller = "App\\Controller\\".$controller;

if (!class_exists($controller)) {
    die("La classe controller ".$controller." n'existe pas");
}

$objectController = new $controller();

if (!method_exists($objectController, $action)) {
    die("L'action ".$action." n'existe pas dans le controller ".$controller);
}

$objectController->$action(...$params);


