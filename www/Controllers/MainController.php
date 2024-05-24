<?php
namespace App\Controller;
use App\Core\View;
class MainController
{
    public function home()
    {
        //Appeler un template Front et la vue MainController/Home
        $view = new View("MainController/home", "Back");
        //$view->setView("MainController/Home");
        //$view->setTemplate("Front");
        $view->render();
    }
    public function logout()
    {
        //Déconnexion
        //Redirection
    }

}