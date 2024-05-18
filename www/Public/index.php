<?php

namespace App;

use App\Core\Security;

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

//http://localhost/login
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
    die("Page 404");
}

if(empty($listOfRoutes[$uri]["Controller"]) || 
    empty($listOfRoutes[$uri]["Action"]) || 
    empty($listOfRoutes[$uri]["Security"]) || 
    empty($listOfRoutes[$uri]["Role"])) 
    {
    header("Internal Server Error", true, 500);
    die("Le fichier routes.yml ne contient pas de controller, d'action, de sécurité ou de role pour l'uri :".$uri);
}

$controller = $listOfRoutes[$uri]["Controller"];
$action = $listOfRoutes[$uri]["Action"];
$role = $listOfRoutes[$uri]["Role"];

echo $role;


// instantiate Core/security
$securityGuard = new Security(); // maintenant regarde le constructor de security dans app/core donc
// // oui pas le controller la c'est pas lié au controller ce qu'on fait Nope, c'est quoi un constructor?
// Ok le constructor class Security a une fonction isLogged qui renvoie un boolean, par defaut false
// Bah c'est le truc juste au dessus des classes ?en gros dans le constructor tu as des classes et tu peux les reutiliser pour
// ca c'ets le namespace et des uses // c'est l'ensemble des classes présentes ? // nope
// // Si tu la vois rien c'est le constructor par défaut, regarde le View
// public function __construct // Yup, c'est cette fonction la qui est appellé quand tu fais un new Class
// Donc il faut un constructor dans security // non parce que la a l'heure actuelle il a besoin de rien initialiser (pas de propriété)
// Bah jcomprend rien alors si il faut rien nul part mdr, c'est juste que si tu n'as pas de constructor c'est un ne"w
// sans argument genre new Security() rien besoin de mettre dans les parenthèse // ok donc là je suis bien il m'a fait un nouveau security
// yes maintenant tu peux utliser les fonctions
// Genre la tu peux vérifier si le user est connecté et est ce que ta route a besoin que tu sois logged in
// $security sera egal a ce que je lui ai foutu dans mon toutes.yml ? a putain j'avais pas vu ton nom de variable
// en vrai check juste le role, Guest = not logged, Admin = logged ou un boolean needAuthentication a la place de role
// Comme ça tu peux vérifier grace a ton guard si tu match les pré requis de ta route, je vais me faire chauffer ma gamelle j'arrive
// bonap // TY

echo $securityGuard->isLogged();

// je check ce que ça me rend en fait tu te rends plus compte mais les new et mon cul c'est hyper confusant c'est pas un mot mais on scomprend c'est lié a rien c'est gratos
//no soucis je te referais un cours // ty // en gros class = moule , instance = gateau ok? ouais
// Donc maintenant dans ta tu lui donnes des fonction que tu peux appeler, et bah du coup ton instance possede c'est methodes
// // pas clair trop le bordel, je repartirais d'un cours vraiment basique je pense

// en vrai après $securityGuard mets juste -> voila je lui assigne la fonction ? non tu utilise la fonction que tu as défini dans la classe
// ok donc dans mon $securityGuard j'utilise la fonction isLogged() | Dans ou Pour mon $securityGuard? pas clair ta question
// Je fais passer ma value de $securityGuard dans la fonction isLogged() ? non la method is logged te retourne quelque chose bool
// yes poiur le moment tout le temps false il faudra que tu modifie la method poru savoir si tu es bien loggedIn
//ok donc ça jle fais dans mon islogged() dans la classe

//if($security === false) {
//    die("Security on False");
//}
//echo "Security on True";


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

