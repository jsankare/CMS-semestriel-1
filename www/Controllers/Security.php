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

        //Je vérifie que l'utilisateur n'est pas connecté sinon j'effectue une redirection
        if(isset($_SESSION['user_id'])) {
            header('Location: http://localhost/profile');
        }

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
            echo "Register successful";
        }
        $view = new View("Security/register"); // Création de la vue (page HTML)
        $view->assign("form", $form->build()); // Passe le form à la vue
        $view->render(); // Render de la page HTML
    }
    public function logout(): void
    {

        // Check if the user is logged in
        if (isset($_SESSION['user_id'])) {
            // Unset the user ID from the session to logout
            unset($_SESSION['user_id']);
            header('Location: http://localhost/login');
        } else {
            echo "Vous n'êtes pas connecté.";
        }
    }

    public function profile(): void
    {
        if (isset($_SESSION['user_id'])) {
           $user = (new User())->findOneById($_SESSION['user_id']);
            if ($user) {
                $form = new Form("Page");

                $view = new View("Security/profile");
                $view->assign('authUser', $user); // Le nom authUser c'est juste une référence entre ici et la vue
                $view->assign('form', $form->build());

                if( $form->isSubmitted() && $form->isValid()) {
                    // Mettre un check pour vérifier si le nom de la page existe pas deja
                    $page = new Page();
                    $page->setTitle($_POST["title"]);
                    $page->setContent($_POST["description"]);
                    $page->save();
                    echo "isallgood";
                }

                $view->render();
            } else {
               echo "Erreur, utilisateur non trouvé";
          }
        } else {
            echo "Vous devez être connecté pour voir cette page";
        }
    }
}
