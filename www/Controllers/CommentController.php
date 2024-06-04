<?php

namespace App\Controller;

use App\Core\Form;
use App\Models\Comment;
use App\Core\View;


class CommentController
{
    public function add(): void
    {
        $commentForm = new Form("Comments");
        $article_id = $_GET['article_id'];

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment = new Comment();
            $comment->setArticleId($article_id);
            $comment->setUserId($_SESSION['user_id']); 
            $comment->setContent($_POST["content"]);
            $comment->setStatus('pending');
            $comment->save();

            header('Location: /article/home');
            exit();
        } else {
            $view = new View("Comment/create", "back");
            $view->assign('commentForm', $commentForm->build());
            $view->assign('article_id', $article_id);
            $view->assign('error', 'Le formulaire n\'a pas été soumis ou n\'est pas valide.');
            $view->render();
        }
    }

    public function reject(): void
    {
        if (isset($_GET['id'])) {
            $comment = (new Comment())->findOneById($_GET['id']);
            if ($comment) {
                $comment->delete();
            } else {
                echo 'Commentaire non trouvé.';
                exit();
            }
        } else {
            echo 'ID de commentaire non spécifié.';
            exit();
        }

        header('Location: /comment/moderate');
        exit();
    }

    public function list(): void
    {
        $articleModel = new Comment();
        $comments = $articleModel->findAll();
        $view = new View("Comment/home", "back");
        $view->assign('comments', $comments);
        $view->render();
    }

    
}
