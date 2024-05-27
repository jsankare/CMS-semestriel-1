<?php
namespace App\Controller;

use App\Core\View;
use App\Models\User;
class UserController
{

    public function delete(): void
    {

    }
    public function show(): void
    {
        echo "Affichage d'un user";
    }
    public function edit(): void
    {

    }
    public function add(): void
    {

    }
    public function list(): void
    {
        $currentUser = (new User())->findOneById($_SESSION['user_id']);

        $userModel = new User();
        $users = $userModel->findAll();

        $view = new View("Users/home", "back");
        $view->assign('users', $users);
        $view->render();
    }

}