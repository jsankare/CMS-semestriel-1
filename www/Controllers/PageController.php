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

    }

    public function edit(): void
    {

    }

    public function add(): void
    {

        $user = (new User())->findOneById($_SESSION['user_id']);
        $pageForm = new Form("Page");

        if( $pageForm->isSubmitted() && $pageForm->isValid()) {
            $dbPage = (new Page())->findOneByTitle($_POST["title"]);
            if ($dbPage) {
                echo "Ce nom de page est déjà pris";
                exit;
            }
            $page = new Page();
            $page->setTitle($_POST["title"]);
            $page->setContent($_POST["content"]);
            $page->setCreatorId($user->getId()); // Ajout id du createur
            $page->save();
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

}