<?php
namespace App\Controller;

use App\Models\Page;
use App\Core\View;

class ErrorController
{
    public function misdirection(): void {
        $pages = (new Page())->findAll();

        $view = new View("Error/misdirection", "front");
        $view->assign('pages', $pages);
        $view->render();
    }

    public function serverError(): void {
        $pages = (new Page())->findAll();

        $view = new View("Error/server", "front");
        $view->assign('pages', $pages);
        $view->render();
    }

    public function unauthorized(): void {
        $pages = (new Page())->findAll();

        $view = new View("Error/unauthorized", "front");
        $view->assign('pages', $pages);
        $view->render();
    }

    public function notImplemented(): void {
        $pages = (new Page())->findAll();

        $view = new View("Error/notImplemented", "front");
        $view->assign('pages', $pages);
        $view->render();
    }

}