<?php
namespace App\Controller;

use App\Core\View;
use App\Models\Page;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;

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
        $commentModel = new Comment();
        $userModel = new User();

        $pages = $pageModel->findAll();
        $articles = $articleModel->findAll();
        $users = $userModel->findAll();
        $comments = $commentModel->findAll();

        $pageCount = $pageModel->count();
        $articleCount = $articleModel->count();
        $userCount = $userModel->count();
        $commentCount = $commentModel->count();

        $articlesWithComments = $articleModel->findArticlesWithComments();
        $articleWithCommentCount = count($articlesWithComments);

        // Compter les users par role
        $guestAmount = 0;
        $userAmount = 0;
        $editorAmount = 0;
        $moderatorAmount = 0;
        $adminAmount = 0;

        foreach ($users as $presentUser) {
            switch ($presentUser->getStatus()) {
                case 0:
                    $guestAmount++;
                    break;
                case 1:
                    $userAmount++;
                    break;
                case 2:
                    $editorAmount++;
                    break;
                case 3:
                    $moderatorAmount++;
                    break;
                case 4:
                    $adminAmount++;
                    break;
            }
        }

        $view = new View("Main/dashboard", "back");

        $view->assign('user', $currentUser);

        $view->assign('pages', $pages);
        $view->assign('articles', $articles);
        $view->assign('comments', $comments);
        $view->assign('users', $users);

        $view->assign('pageCount', $pageCount);
        $view->assign('articleCount', $articleCount);
        $view->assign('userCount', $userCount);
        $view->assign('commentCount', $commentCount);
        $view->assign('articlesWithComments', $articlesWithComments);
        $view->assign('articleWithCommentCount', $articleWithCommentCount);

        $view->assign('guestAmount', $guestAmount);
        $view->assign('userAmount', $userAmount);
        $view->assign('editorAmount', $editorAmount);
        $view->assign('moderatorAmount', $moderatorAmount);
        $view->assign('adminAmount', $adminAmount);

        $view->render();
    }
}