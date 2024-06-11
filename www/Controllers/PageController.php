<?php
namespace App\Controller;

use App\Core\Form;
use App\Models\User;
use App\Models\Page;
use App\Core\View;

class PageController
{

    public function show(): void
    {
        if (isset($_GET['id'])) {
            $pageId = intval($_GET['id']);
            $page = (new Page())->findOneById($pageId);

            if ($page) {
                $view = new View("Page/showPage", "front");
                $view->assign('page', $page);
                $view->render();
            } else {
                echo "Page non trouvée";
            }
        } else {
            echo "ID page non spécifié";
        }
    }

    public function add(): void
{
    $user = (new User())->findOneById($_SESSION['user_id']);
    $pageForm = new Form("Page");

    if ($pageForm->isSubmitted() && $pageForm->isValid()) {
        $dbPage = (new Page())->findOneByTitle($_POST["title"]);
        if ($dbPage) {
            echo "Ce nom de page est déjà pris";
            exit;
        }

        $allowed_tags = '<h1><h2><h3><h4><h5><h6><p><b><i><u><strike><blockquote><code><ul><ol><li><a><img><div><span><br><strong><em>';
        $content = strip_tags($_POST["content"], $allowed_tags);

        $page = new Page();
        $page->setTitle($_POST["title"]);
        $page->setDescription($_POST["description"]);
        $page->setContent($content);
        $page->setCreatorId($user->getId());
        $page->save();

        header('Location: /page/home');
        exit();
    }

    $view = new View("Page/create", "back");
    $view->assign('pageForm', $pageForm->build());
    $view->render();
}

    public function list(): void
    {
        $user = (new User())->findOneById($_SESSION['user_id']);

        $pageModel = new Page();
        $pages = $pageModel->findAll();

        $view = new View("Page/home", "back");
        $view->assign('pages', $pages);
        $view->render();
    }

    public function delete(): void
    {
        if (isset($_GET['id'])) {
            $pageId = intval($_GET['id']);
            $page = (new Page())->findOneById($pageId);

            if ($page) {
                $page->delete();
                header('Location: /page/home');
                exit();
            } else {
                echo "Page non trouvée";
            }
        } else {
            echo "ID page non spécifié";
        }
    }

    public function edit(): void
    {
        if (isset($_GET['id'])) {
            $pageId = intval($_GET['id']);
            $page = (new Page())->findOneById($pageId);

            if ($page) {
                $pageForm = new Form("Page");
                $pageForm->setValues([
                    'title' => $page->getTitle(),
                    'description' => $page->getDescription(),
                    'content' => $page->getContent()
                ]);

                if ($pageForm->isSubmitted() && $pageForm->isValid()) {
                    $page->setTitle($_POST['title']);
                    $page->setDescription($_POST['description']);
                    $page->setContent($_POST['content']);
                    $page->save();

                    header('Location: /page/home');
                    exit();
                }

                $view = new View("Page/edit", "back");
                $view->assign('pageForm', $pageForm->build());
                $view->render();
            } else {
                echo "Page non trouvé !";
            }
        } else {
            echo "ID page non spécifié !";
        }
    }

}