<?php
namespace App\Controller;

use App\Core\Form;
use App\Core\View;
use App\Models\Article;
use App\Models\User;
use App\Models\Comment;
use App\Models\Page;

class ArticleController
{

    public function show(): void
    {
        $articleModel = new Article();
        $pageModel = new Page();

        $articles = $articleModel->findAll();
        $pages = $pageModel->findAll();

        foreach ($articles as $article) {
            $comments = (new Comment())->findCommentsByArticleId($article->getId());
            $article->comments = $comments;
        }

        $view = new View("article/show", "front");
        $view->assign('pages', $pages);
        $view->assign('articles', $articles);
        $view->render();
    }

    public function add(): void
    {
        $user = (new User())->findOneById($_SESSION['user_id']);
        $articleForm = new Form("Article");

        $title = "";
        $description = "";
        $content = "";

        if ($articleForm->isSubmitted()) {

            $title = $_POST["title"] ?? "";
            $description = $_POST["description"] ?? "";
            $content = $_POST["content"] ?? "";

            if ($articleForm->isValid()) {
                $dbArticle = (new Article())->findOneByTitle($title);
                if ($dbArticle) {
                    header("Ce nom d'article est déjà pris", true, 409);
                    header('Location: /409');
                    exit();
                } else {
                    $allowed_tags = '<h1><h2><h3><h4><h5><h6><p><b><i><u><strike><s><del><blockquote><center><code><ul><ol><li><a><img><div><span><br><strong><em>';
                    $sanitized_content = strip_tags($content, $allowed_tags);
                    $sanitized_title = strip_tags($title, $allowed_tags);
                    $sanitized_description = strip_tags($description, $allowed_tags);

                    $article = new Article();
                    $article->setTitle($sanitized_title);
                    $article->setDescription($sanitized_description);
                    $article->setContent($sanitized_content);
                    $article->setCreatorId($user->getId());
                    $article->save();

                    header('Location: /article/home');
                    exit();
                }
            }
        }

        $articleForm->setValues([
            "title" => $title,
            "description" => $description,
            "content" => $content,
        ]);

        $view = new View("Article/create", "Back");
        $view->assign('articleForm', $articleForm->build());
        $view->render();
    }


    public function list(): void
    {
        $articleModel = new Article();

        $articles = $articleModel->findAll();
        $view = new View("article/home", "back");
        $view->assign('articles', $articles);
        $view->render();
    }

    public function predelete(): void {

        if (isset($_GET['id'])) {
            $articleId = intval($_GET['id']);
            $article = (new Article())->findOneById($articleId);
        } else {
            header("Impossible de récupérer l'article", true, 500);
            header('Location: /500');
            exit();
        }

        $view = new View('Article/delete', 'back');
        $view->assign('article', $article);
        $view->render();
    }

    public function delete(): void
    {
        if (isset($_GET['id'])) {
            $articleId = intval($_GET['id']);
            $article = (new Article())->findOneById($articleId);

            if ($article) {
                $commentModel = new Comment();
                $comments = $commentModel->findCommentsByArticleId($articleId);
                foreach ($comments as $comment) {
                    $comment->delete();
                }
                $article->delete();
                header('Location: /article/home');
                exit();
            } else {
                header("Article non trouvé", true, 404);
                header('Location: /404');
                exit();
            }
        } else {
            header("Article ID non trouvé", true, 500);
            header('Location: /500');
            exit();
        }
    }

    public function edit(): void
    {
        if (isset($_GET['id'])) {
            $articleId = intval($_GET['id']);
            $article = (new Article())->findOneById($articleId);

            if ($article) {
                $articleForm = new Form("Article");
                $articleForm->setValues([
                    'title' => $article->getTitle(),
                    'description' => $article->getDescription(),
                    'content' => $article->getContent()
                ]);

                if ($articleForm->isSubmitted() && $articleForm->isValid()) {
                    $allowed_tags = '<h1><h2><h3><h4><h5><h6><p><b><i><u><strike><s><del><blockquote><center><code><ul><ol><li><a><img><div><span><br><strong><em>';

                    $article->setTitle(strip_tags($_POST['title'], $allowed_tags));
                    $article->setDescription(strip_tags($_POST['description'], $allowed_tags));
                    $article->setContent(strip_tags($_POST['content'], $allowed_tags));
                    $article->save();

                    header('Location: /article/home');
                    exit();
                }

                $view = new View("Article/edit", "back");
                $view->assign('articleForm', $articleForm->build());
                $view->render();
            } else {
                header("Article non trouvé", true, 404);
                header('Location: /404');
                exit();
            }
        } else {
            header("ID article non spécifié", true, 500);
            header('Location: /500');
            exit();
        }
    }

}