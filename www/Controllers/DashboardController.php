<?php
namespace App\Controller;

use App\Core\View;
use App\Models\Page;
use App\Models\User;

class DashboardController
{

    public function show(): void
    {
        $currentUserId = $_SESSION['user_id'];
        if ($currentUserId) {
            $userModel = new User();
            $currentUser = $userModel->findOneById($currentUserId);
        } else {
            $currentUser = null;
        }
        $pageModel = new Page();
        $pages = $pageModel->findAll();

        $view = new View("Main/dashboard", "back");
        $view->assign('user', $currentUser);
        $view->assign('pages', $pages);
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