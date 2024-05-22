<?php
namespace App\Controller;
use App\Core\Form;
// use App\Core\Security as Auth;
use App\Core\View;
use App\Models\User;
use App\Models\Page;

class Security
{

    public function login(): void
    {
        $form = new Form("Login");
        if( $form->isSubmitted() && $form->isValid() ) {
            // Met toutes les infos du user correspondant dans une variable
            $user = (new User())->findOneByEmail($_POST["email"]);
            if ($user) {
                // Compare le password saisi par l'user et celui correspondant au mail en DB
                if (password_verify($_POST["password"], $user->getPassword())) {
                    // on store le user ID dans la session
                    $_SESSION['user_id'] = $user->getId();
                    header('Location: http://localhost/profile');
                }
            } else {
                echo "Invalid email or password";
            }
        }
        $view = new View("Security/login"); // instantiation
        $view->assign("form", $form->build());
        $view->render();


    }
    public function register(): void
    {
        $form = new Form("Register"); // Crée un formulaire

        if( $form->isSubmitted() && $form->isValid() ) {
            $dbUser = (new User())->findOneByEmail($_POST["email"]);
            if ($dbUser) {
                echo "Un user existe déjà avec cette adresse email";
                exit;
            }
            $user = new User(); // Initialisation d'un nouveau User
            $user->setFirstname($_POST["firstname"]);
            $user->setLastname($_POST["lastname"]);
            $user->setEmail($_POST["email"]);
            $user->setPassword($_POST["password"]);
            $user->save();
            header('Location: http://localhost/login');
        }

        $view = new View("Security/register"); // Création de la vue (page HTML)
        $view->assign("form", $form->build()); // Passe le form à la vue
        $view->render(); // Render de la page HTML
    }
    public function logout(): void
    {
        unset($_SESSION['user_id']);
        header('Location: http://localhost/login');
    }

    public function profile(): void
    {
        $user = (new User())->findOneById($_SESSION['user_id']);

        if (!$user) {
            echo 'erreur user not found';
            die;
        }

        $form = new Form("Page");

        if( $form->isSubmitted() && $form->isValid()) {
            $dbPage = (new Page())->findOneByTitle($_POST["title"]);
            if ($dbPage) {
                echo "Ce nom de page est déjà pris";
                exit;
            }
            $page = new Page();
            $page->setTitle($_POST["title"]);
            $page->setContent($_POST["content"]);
            $page->save();
        }

        $view = new View("Security/profile");
        $view->assign('authUser', $user); // Le nom authUser c'est juste une référence entre ici et la vue
        $view->assign('form', $form->build());
        $view->render();
    }
}
