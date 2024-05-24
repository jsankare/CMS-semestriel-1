<?php
namespace App\Controller;



use App\Core\Form;
use App\Core\View;
use App\Models\Article;
use App\Models\User;

class ArticleController
{

    public function delete(): void
    {

    }

    public function show(): void
    {

    }

    public function edit(): void
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

    }

}