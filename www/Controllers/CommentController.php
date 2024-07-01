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

                    $allowed_tags = '<h1><h2><h3><h4><h5><h6><p><b><i><u><strike><s><del><blockquote><code><ul><ol><li><a><img><div><span><br><strong><em>';
                    $sanitized_content = strip_tags($content, $allowed_tags);

                    $userId = (int)$_SESSION['user_id'];

                    $comment = new Comment();
                    $comment->setArticleId($articleId);
                    $comment->setUserId($userId);
                    $comment->setContent($sanitized_content);
                    $comment->save();
                    header("Commentaire posté", true, 404);
                    header('Location: /articles');
                    exit();
                } else {
                    unset($_SESSION['user_id']);
                    session_destroy();
                    header("Utilisateur non connecté", true, 403);
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
                header("Commentaire non trouvé", true, 404);
                header('Location: /404');
                exit();
            }
        } else {
            header("ID Utilisateur non trouvé", true, 500);
            header('Location: /500');
            exit();
        }
        header("Comment deleted", true, 200);
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
                header("Article non trouvé", true, 404);
                header('Location: /404');
                exit();
            }
        } else {
            header("ID Article non spécifié", true, 500);
            header('Location: /500');
            exit();
        }
    }
}
