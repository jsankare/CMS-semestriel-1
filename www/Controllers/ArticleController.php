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

        // Initialisation des valeurs des champs
        $title = "";
        $description = "";
        $content = "";

        if ($articleForm->isSubmitted()) {
            // Récupérer les valeurs des champs soumis
            $title = $_POST["title"] ?? "";
            $description = $_POST["description"] ?? "";
            $content = $_POST["content"] ?? "";

            if ($articleForm->isValid()) {
                $dbArticle = (new Article())->findOneByTitle($title);
                if ($dbArticle) {
                    echo "Ce nom d'article est déjà pris";
                } else {
                    $allowed_tags = '<h1><h2><h3><h4><h5><h6><p><b><i><u><strike><s><del><blockquote><code><ul><ol><li><a><img><div><span><br><strong><em>';
                    $sanitized_content = strip_tags($content, $allowed_tags);

                    $article = new Article();
                    $article->setTitle($title);
                    $article->setDescription($description);
                    $article->setContent($sanitized_content);
                    $article->setCreatorId($user->getId());
                    $article->save();

                    header('Location: /article/home');
                    exit();
                }
            }
        }

        // Ajouter les valeurs des champs au formulaire pour les réafficher en cas d'erreur
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
            echo "impossible de récupérer l'article";
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
                $article->delete();
                header('Location: /article/home');
                exit();
            } else {
                echo "Article non trouvé";
            }
        } else {
            echo "ID article non spécifié";
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
                    $article->setTitle($_POST['title']);
                    $article->setDescription($_POST['description']);
                    $article->setContent($_POST['content']);
                    $article->save();

                    header('Location: /article/home');
                    exit();
                }

                $view = new View("Article/edit", "back");
                $view->assign('articleForm', $articleForm->build());
                $view->render();
            } else {
                echo "Article non trouvé !";
            }
        } else {
            echo "ID article non spécifié !";
        }
    }

}