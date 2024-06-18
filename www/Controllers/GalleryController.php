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
        $galleryForm = new Form('Gallery');

        if ($galleryForm->isSubmitted() && $galleryForm->isValid()) {
            $_FILES['title'] = $_POST["title"];
            $_FILES['description'] = $_POST["description"];
            $_FILES['image'] = $_POST["image"];
        }

        $view = new View('Gallery/home', 'front');
        $view->assign('galleryForm', $galleryForm->build());
        $view->assign('pages', $pages);
        $view->render();
    }

}