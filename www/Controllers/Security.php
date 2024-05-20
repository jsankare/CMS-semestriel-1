<?php
namespace App\Controller;
use App\Core\Form;
use App\Core\Security as Auth;
use App\Core\View; // Ici tu as l'import
use App\Models\User;

class Security{

    public function login(): void
    {
        //Je vérifie que l'utilisateur n'est pas connecté sinon j'affiche un message

        // Debut de session
        session_start();

        $form = new Form("Login");
        if( $form->isSubmitted() && $form->isValid() ) {
            // Met toutes les infos du user correspondant dans une variable
            $user = (new User())->findOneByEmail($_POST["email"]);
            if ($user) {
                // Compare le password saisi par l'user et celui correspondant au mail en DB
                if (password_verify($_POST["password"], $user->getPassword())) {
                    // on store le user ID dans la session
                    $_SESSION['user_id'] = $user->getId();
                    echo $_SESSION['user_id'];
                    echo "Login successful!";
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

        $form = new Form("Register");

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

        $view = new View("Security/register");
        $view->assign("form", $form->build());
        $view->render();
    }
    public function logout(): void
    {
        // retire le user ID de la session pour logout
        unset($_SESSION['userId']);
        echo "Se déconnecter";
    }

    public function profile(): void
    {
        // Start session
        session_start();

        // Check if user is logged in (user ID is stored in session)
        if (isset($_SESSION['user_id'])) {
            // User is logged in
            echo "Welcome, you are logged in!";
        } else {
            // User is not logged in
            echo "You need to log in to access this page.";
            // You can redirect the user to the login page if needed
        }
    }
}
