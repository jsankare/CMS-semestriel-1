<?php
namespace App\Controller;

use App\Core\View;
use App\Models\Page;
use App\Models\Article;
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
        $articleModel = new Article();
        $userModel = new User();
        
        $users = $userModel->findAll();
        $pages = $pageModel->findAll();
        $articles = $articleModel->findAll();

        $view = new View("Main/dashboard", "back");
        $view->assign('users', $users);
        $view->assign('currentUser', $currentUser);
        $view->assign('pages', $pages);
        $view->assign('articles', $articles);
        $view->render();
    }
}