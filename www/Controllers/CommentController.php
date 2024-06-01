<?php

namespace App\Controller;

use App\Core\Form;
use App\Models\Comment;
use App\Core\View;


class CommentController
{
    public function add(): void
    {
        $commentForm = new Form("Comment");

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment = new Comment();
            $comment->setArticleId($_POST["article_id"]);
            $comment->setUserId($_SESSION['user_id']);
            $comment->setContent($_POST["content"]);
            $comment->setStatus('pending');
            $comment->save();

            header('Location: /article/view?id=' . $_POST["article_id"]);
            exit();
        }

        $view = new View("Comment/add", "front");
        $view->assign('commentForm', $commentForm->build());
        $view->render();
    }

    
}
