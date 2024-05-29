<?php
namespace App\Controller;



use App\Core\Form;
use App\Core\View;
use App\Models\Article;
use App\Models\User;

class ArticleController
{

    public function show(): void
    {

    }

    public function add(): void
    {
        $user = (new User())->findOneById($_SESSION['user_id']);
        $articleForm = new Form("Article");

        if( $articleForm->isSubmitted() && $articleForm->isValid()) {
            $dbArticle = (new Article())->findOneByTitle($_POST["title"]);
            if ($dbArticle) {
                echo "Ce nom d'article est déjà pris";
                exit;
            }
            $article = new Article();
            $article->setTitle($_POST["title"]);
            $article->setDescription($_POST["description"]);
            $article->setContent($_POST["content"]);
            $article->setCreatorId($user->getId());
            $article->save();
        }

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