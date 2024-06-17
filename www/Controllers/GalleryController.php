<?php
namespace App\Controller;

use App\Core\Form;
use App\Core\View;
use App\Models\Page;

class GalleryController
{

    public function home(): void
    {
        $pages = (new Page())->findAll();

        $view = new View('Gallery/home', 'front');
        $view->assign('pages', $pages);
        $view->render();
    }

}