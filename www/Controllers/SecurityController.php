<?php
namespace App\Controller;
use App\Core\Form;
// use App\Core\Security as Auth;
use App\Core\View;
use App\Models\User;
use App\Models\Article;
use App\Models\Page;
use PHPMailer\PHPMailer\PHPMailer;

class SecurityController
{

    public function login(): void
    {
        $form = new Form("Login");
        if( $form->isSubmitted() && $form->isValid() ) {
            $user = (new User())->findOneByEmail($_POST["email"]);
            if ($user) {
                if ($user->getStatus() == 0) {
                    echo "Vous devez valider votre compte avant de vous connecter";
                // Compare le password saisi par l'user et celui correspondant au mail en DB
                } elseif (password_verify($_POST["password"], $user->getPassword())) {
                   // on store le user ID dans la session
                   $_SESSION['user_id'] = $user->getId();
                   $_SESSION['user_status'] = $user->getStatus();
                   header('Location: ' . $_ENV['BASE_URL'] . '/profile');
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

            $existingUsers = (new User())->findAll();
            $status = count($existingUsers) === 0 ? 4 : 0;

            $validation_code = md5(uniqid(rand(), true));

            $user = new User(); // Initialisation d'un nouveau UserController
            $user->setFirstname($_POST["firstname"]);
            $user->setLastname($_POST["lastname"]);
            $user->setEmail($_POST["email"]);
            $user->setPassword($_POST["password"]);
            $user->setStatus($status);
            $user->setValidationCode($validation_code);
            $user->save();

            $this->emailValidation($user);

            header('Location: ' . $_ENV['BASE_URL'] . '/login');
        }

        $view = new View("Security/register"); // Création de la vue (page HTML)
        $view->assign("form", $form->build()); // Passe le form à la vue
        $view->render(); // Render de la page HTML
    }
    public function logout(): void
    {
        unset($_SESSION['user_id']);
        header('Location: ' . $_ENV['BASE_URL'] . '/login');
    }

    public function profile(): void
    {
        $user = (new User())->findOneById($_SESSION['user_id']);

        if (!$user) {
            echo 'erreur user not found';
            die;
        }

        // Récupération des pages
        $pageModel = new Page();
        $pages = $pageModel->findAll();
        

        echo'Page profile';
        $view = new View("Security/profile", "front");
        $view->assign("authUser", $user);
        $view->assign("pages", $pages); // Passer les pages à la vue
        $view->render();
    }

    private function emailValidation(User $user): void {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $_ENV['PHPMAILER_HOST'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $_ENV['PHPMAILER_PORT'];
        $phpmailer->Username = $_ENV['PHPMAILER_USERNAME'];
        $phpmailer->Password = $_ENV['PHPMAILER_PASSWORD'];

        $phpmailer->setFrom($_ENV['PHPMAILER_ADDRESS_FROM'], 'Mailtrap');
        $phpmailer->addReplyTo($_ENV['PHPMAILER_ADDRESS_FROM'], 'Mailtrap');
        $phpmailer->addAddress($user->getEmail(), $user->getFirstname() . ' ' . $user->getLastname());
        $validation_code = $user->getValidationCode();

        $validationUrl = $_ENV['BASE_URL'] . '/accountVerification?email=' . urlencode($user->getEmail()) . '&code=' . $validation_code;
        $phpmailer->isHTML(true);
        $phpmailer->Subject = 'Bonjour '. $user->getFirstname() .' !';
        $phpmailer->Body    = '<h1>Votre code de validation</h1><p>Cliquez sur le lien ci-dessous pour activer votre compte</p><a href="' . $validationUrl . '">Cliquez ici</a><p>Si le lien ne s\'affiche pas correctement, vous pouvez coller ce lien dans votre URL :</p>' .$validationUrl;
        $phpmailer->AltBody = 'Veuillez activer votre HTML pour accéder au code d\'activation de votre compte';

        if ($phpmailer->send()) {
            echo 'Le message a bien été envoyé';
        } else {
            echo 'Le message n\a pas pu être envoyé';
            echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
        }
    }


    public function accountVerification(): void {
        if (isset($_GET['email']) && isset($_GET['code'])) {
            $email = $_GET['email'];
            $validation_code = $_GET['code'];
            $user = (new User())->findOneByEmail($email);

            if ($user && $user->getValidationCode() === $validation_code) {
                if ($user->getStatus() !== 0) {
                    echo "Votre compte est déjà vérifié";
                    die();
                }
                $user->setStatus(1);
                $user->save();
                echo "Votre compte a été confirmé avec succès! Vous pouvez fermer cette fenêtre et aller sur l'écran de connexion";
            } else {
                echo "Code de validation invalide ou adresse email incorrecte.";
            }
        } else {
            echo "Aucun code de validation ou adresse email fournis.";
        }
    }

}