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


$uri = $_SERVER["REQUEST_URI"];
if(strlen($uri) > 1)
    $uri = rtrim($uri, "/");
$uriExploded = explode("?",$uri);
$uri = $uriExploded[0];


if(file_exists("../Routes.yml")) {
    $listOfRoutes = yaml_parse_file("../Routes.yml");
}else{
    header("Internal Server Error", true, 500);
    die("Le fichier de routing ../Routes.yml n'existe pas");
}

if(empty($listOfRoutes[$uri])) {
    header("Status 404 Not Found", true, 404);
    die("PageForm 404");
}

// !isset() pour les bool, empty() considere vide si bool:false
if(
    empty($listOfRoutes[$uri]["Controller"]) ||
    empty($listOfRoutes[$uri]["Action"]) ||
    !isset($listOfRoutes[$uri]["Security"]) ||
    empty($listOfRoutes[$uri]["Role"])
) {
    header("Internal Server Error", true, 500);
    die("Le fichier routes.yml ne contient pas de controller, d'action, de sécurité ou de role pour l'uri :".$uri);
}

$controller = $listOfRoutes[$uri]["Controller"];
$action = $listOfRoutes[$uri]["Action"];
$role = $listOfRoutes[$uri]["Role"];
$isProtected = $listOfRoutes[$uri]["Security"];

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

// Est-ce qu'il y a besoin d'un rôle pour accéder à la route ?

//include "../Controllers/".$controller.".php";
if(!file_exists("../Controllers/".$controller.".php")){
    die("Le fichier controller ../Controllers/".$controller.".php n'existe pas");
}
include "../Controllers/".$controller.".php";

$controller = "App\\Controller\\".$controller;

if( !class_exists($controller) ){
    die("La class controller ".$controller." n'existe pas");
}
$objetController = new $controller();

if( !method_exists($controller, $action) ){
    die("La methode ".$action." n'existe pas dans le controller ".$controller);
}

$objetController->$action();
