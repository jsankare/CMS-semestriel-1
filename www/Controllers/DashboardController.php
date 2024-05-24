<?php
namespace App\Controller;

use App\Core\View;

class DashboardController
{

    public function delete(): void
    {

    }

    public function show(): void
    {

        $view = new View("Main/dashboard", "back");
        $view->render();
    }

    public function edit(): void
    {

    }

    public function add(): void
    {

    }

    public function list(): void
    {

    }

}