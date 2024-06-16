<?php
namespace App\Controller;

use App\Core\View;
use App\Models\User;
use App\Models\Page;

class MainController
{
    public function home()
    {
        $pageModel = New Page();
        $pages = $pageModel->findAll();

        $view = new View("Main/home", "front");
        $view->assign('pages', $pages);
        $view->render();
    }

}