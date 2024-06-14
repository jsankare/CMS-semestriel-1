<?php
namespace App\Controller;
use App\Core\View;
class MainController
{
    public function home()
    {
        $view = new View("Main/home", "front");
        $view->render();
    }

}