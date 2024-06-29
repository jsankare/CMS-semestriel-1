<?php
namespace App\Controller;

use App\Core\Form;
use App\Models\User;
use App\Models\Page;
use App\Core\View;

class PageController
{

    public function home(): void
    {
        $mainPage = (new Page())->findMainPage();
        $pages = (new Page())->findAll();

        if ($mainPage) {
            $view = new View("Main/home", "front");
            $view->assign('mainPage', $mainPage);
            $view->assign('pages', $pages);
            $view->render();
        } else {
            echo "Aucune page principale définie.";
        }
    }


    public function show(): void
{
    $uriSegments = explode('/', $_SERVER['REQUEST_URI']);
    if (isset($uriSegments[2])) {
        $slug = $uriSegments[2];
        $currentPage = (new Page())->findOneBySlug($slug);
        if ($currentPage) {
            $pages = (new Page())->findAllExcept($slug);
            $view = new View("Page/showPage", "front");
            $view->assign('currentPage', $currentPage);
            $view->assign('pages', $pages);
            $view->render();
        } else {
            header('Location: /page/404');
            exit();
        }
    } else {
        header('Location: /page/500');
        exit();
    }
}


    public function add(): void
    {
        $user = (new User())->findOneById($_SESSION['user_id']);
        $pageForm = new Form("Page");

        $title = "";
        $description = "";
        $content = "";

        if ($pageForm->isSubmitted()) {

            $title = $_POST["title"] ?? "";
            $description = $_POST["description"] ?? "";
            $content = $_POST["content"] ?? "";

            if ($pageForm->isValid()) {
                $dbPage = (new Page())->findOneByTitle($title);
                if ($dbPage) {
                    echo "Ce nom de page est déjà pris";
                } else {
                    $allowed_tags = '<h1><h2><h3><h4><h5><h6><p><b><i><u><strike><blockquote><code><ul><ol><li><a><img><div><span><br><strong><em>';
                    $sanitized_content = strip_tags($content, $allowed_tags);

                    $page = new Page();
                    $page->setTitle($title);
                    $page->setDescription($description);
                    $page->setContent($sanitized_content);
                    $page->setCreatorId($user->getId());
                    $page->setSlug($this->generateSlug($_POST["title"]));

                    if (isset($_POST['is_main']) && $_POST['is_main'] == '1') {
                        (new Page())->resetMainPage();
                        $page->setIsMain(true);
                    } else {
                        $page->setIsMain(false);
                    }

                    $page->save();

                    header('Location: /page/home');
                    exit();
                }
            }
        }

        $pageForm->setValues([
            "title" => $title,
            "description" => $description,
            "content" => $content,
        ]);

        $view = new View("Page/create", "back");
        $view->assign('pageForm', $pageForm->build());
        $view->render();
    }


    private function generateSlug(string $title): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }

    public function list(): void
    {
        $user = (new User())->findOneById($_SESSION['user_id']);

        $pageModel = new Page();
        $pages = $pageModel->findAll();
        $pageCount = count($pages);

        $view = new View("Page/home", "back");
        $view->assign('pages', $pages);
        $view->assign('pageCount', $pageCount);
        $view->render();
    }

    public function predelete(): void {

        if (isset($_GET['id'])) {
            $pageId = intval($_GET['id']);
            $page = (new Page())->findOneById($pageId);
        } else {
            echo "impossible de récupérer la page";
            exit();
        }

        $view = new View('Page/delete', 'back');
        $view->assign('page', $page);
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
                    'edit-slug' => $page->getSlug(),
                    'content' => $page->getContent(),
                    'is_main' => $page->getIsMain()
                ]);

                if ($pageForm->isSubmitted() && $pageForm->isValid()) {
                    $page->setTitle($_POST['title']);
                    $page->setDescription($_POST['description']);
                    $page->setSlug($_POST['edit-slug']);
                    $page->setContent($_POST['content']);

                    if (isset($_POST['is_main']) && $_POST['is_main'] == '1') {
                        (new Page())->resetMainPage();
                        $page->setIsMain(true);
                    } else {
                        $page->setIsMain(false);
                    }

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

    public function misdirection(): void {
        $pages = (new Page())->findAll();

        $view = new View("Error/misdirection", "front");
        $view->assign('pages', $pages);
        $view->render();
    }

    public function serverError(): void {
        $pages = (new Page())->findAll();

        $view = new View("Error/server", "front");
        $view->assign('pages', $pages);
        $view->render();
    }

    public function unauthorized(): void {
        $pages = (new Page())->findAll();

        $view = new View("Error/unauthorized", "front");
        $view->assign('pages', $pages);
        $view->render();
    }

}