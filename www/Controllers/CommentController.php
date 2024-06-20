<?php

namespace App\Controller;

use App\Core\Form;
use App\Models\Comment;
use App\Models\Article;
use App\Core\View;


class CommentController
{
    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['article_id']) && isset($_POST['content'])) {
                $articleId = (int)$_POST['article_id'];
                $content = trim($_POST['content']);

                if (isset($_SESSION['user_id'])) {
                    $userId = (int)$_SESSION['user_id'];

                    $comment = new Comment();
                    $comment->setArticleId($articleId);
                    $comment->setUserId($userId);
                    $comment->setContent($content);
                    $comment->setStatus('pending');
                    $comment->save();

                    header('Location: /articles');
                    exit();
                } else {
                    header('Location: /login');
                    exit();
                }
            } else {
                $error = "Les données du formulaire sont invalides.";
                $view = new View("Comment/create", "back");
                $view->assign('error', $error);
                $view->render();
            }
        } else {
            $view = new View("Comment/create", "back");
            $view->render();
        }
    }

    public function delete(): void
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

        header('Location: /comments/home');
        exit();
    }

    public function list(): void
    {
        $commentModel = new Comment();

        $comments = $commentModel->findAll();

        $view = new View("Comment/home", "back");
        $view->assign('comments', $comments);
        $view->render();
    }

    public function show(): void
    {
        if (isset($_GET['article_id'])) {
            $articleId = intval($_GET['article_id']);
            $article = (new Article())->findOneById($articleId);

            if ($article) {
                $comments = (new Comment())->findCommentsByArticleId($articleId);

                $view = new View("Comment/list_per_article", "back");
                $view->assign('article', $article);
                $view->assign('comments', $comments);
                $view->render();
            } else {
                echo "Article non trouvé";
                exit();
            }
        } else {
            echo "ID de l'article non spécifié";
            exit();
        }
    }
}
