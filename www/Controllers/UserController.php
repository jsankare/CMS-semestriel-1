<?php
namespace App\Controller;

use App\Core\View;
use App\Core\Form;
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
        $user = (new User())->findOneById($_SESSION['user_id']);
        $userForm = new Form("User");

        if( $userForm->isSubmitted() && $userForm->isValid()) {
            $dbUser = (new User())->findOneByEmail($_POST["email"]);
            if ($dbUser) {
                echo "Ce nom de user est déjà pris";
                exit;
            }
            $user = new User();
            $user->setFirstname($_POST["firstname"]);
            $user->setLastname($_POST["lastname"]);
            $user->setEmail($_POST["email"]);
            $user->setPassword($_POST["password"]);
            $user->save();
        }

        $view = new View("Users/create", "back");
        $view->assign('userForm', $userForm->build());
        $view->render();
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