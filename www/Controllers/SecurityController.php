<?php
namespace App\Controller;
use App\Core\Form;
use App\Core\View;
use App\Models\User;
use App\Models\Page;
use App\Models\Article;
use App\Models\Comment;
use PHPMailer\PHPMailer\PHPMailer;

class SecurityController
{

    public function login(): void
    {
        // Crée un nouveau formulaire
        $form = new Form("Login");
        // Initialisation des valeurs des champs
        $email = "";

        if ($form->isSubmitted()) {
            // Récupérer les valeurs des champs soumis
            $email = $_POST["email"] ?? "";

            if ($form->isValid()) {
                // Instancie un nouvel user avec la methode du model
                $user = (new User())->findOneByEmail($email);
                if ($user) {
                    // Verification du status
                    if ($user->getStatus() == 0) {
                        header("Vous devez valider votre compte avant de vous connecter", true, 403);
                        header('Location: /403');
                        exit();
                    } elseif (password_verify($_POST["password"], $user->getPassword())) {
                        // On store le user ID & le status dans la session
                        $_SESSION['user_id'] = $user->getId();
                        $_SESSION['user_status'] = $user->getStatus();
                        // Redirection
                        header('Location: ' . $_ENV['BASE_URL'] . '/');
                        exit;
                    } else {
                        header("Invalid email or password", true, 404);
                        header('Location: /404');
                        exit();
                    }
                } else {
                    header("Invalid email or password", true, 404);
                        header('Location: /404');
                        exit();
                }
            }
        }

        // Ajouter les valeurs des champs au formulaire pour les réafficher en cas d'erreur
        $form->setValues([
            "email" => $email,
        ]);

        $view = new View("Security/login"); // instantiation
        $view->assign("form", $form->build()); // Assignation + build du formulaire avec la methode de Form
        $view->render(); // Rendu de la vue
    }

    public function register(): void
    {
        $form = new Form("Register");

        $firstname = "";
        $lastname = "";
        $email = "";

        if ($form->isSubmitted()) {

            $firstname = $_POST["firstname"] ?? "";
            $lastname = $_POST["lastname"] ?? "";
            $email = $_POST["email"] ?? "";

            if ($form->isValid()) {
                $dbUser = (new User())->findOneByEmail($email);
                if ($dbUser) {
                    header("Un user existe déjà avec cette adresse email", true, 500);
                    header('Location: /500');
                    exit();
                } else {
                    $existingUsers = (new User())->findAll();
                    $status = count($existingUsers) === 0 ? 4 : 0;
                    $validation_code = count($existingUsers) === 0 ? null : md5(uniqid(rand(), true));

                    $user = new User();
                    $user->setFirstname($firstname);
                    $user->setLastname($lastname);
                    $user->setEmail($email);
                    $user->setPassword($_POST["password"]);
                    $user->setStatus($status);
                    $user->setValidationCode($validation_code);
                    $user->save();

                    count($existingUsers) === 0 ? '' : $this->emailValidation($user);

                    header('Location: ' . $_ENV['BASE_URL'] . '/login');
                    exit;
                }
            }
        }

        $form->setValues([
            "firstname" => $firstname,
            "lastname" => $lastname,
            "email" => $email,
        ]);

        $view = new View("Security/register");
        $view->assign("form", $form->build());
        $view->render();
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        session_destroy();
        header('Location: ' . $_ENV['BASE_URL'] . '/login');
        exit();
    }

    public function profile(): void
    {
        $user = (new User())->findOneById($_SESSION['user_id']);

        if (!$user) {
            header("Error user not found", true, 404);
            header('Location: /404');
            exit();
        }

        $updateProfileForm = new Form("UpdateProfile");
        $updateProfileForm->setValues([
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'email' => $user->getEmail(),
        ]);

        if ($updateProfileForm->isSubmitted() && $updateProfileForm->isValid()) {
            $user->setFirstname($_POST["firstname"]);
            $user->setLastname($_POST["lastname"]);
            $user->setEmail($_POST["email"]);
            $user->save();
            header("Formulaire soumis", true, 200);
            header('Location: /profile');
            exit();
        }

        $pageModel = new Page();
        $commentModel = new Comment();

        $pages = $pageModel->findAll();
        $userComments = $commentModel->findCommentsByUserId($user->getId());

        foreach ($userComments as &$comment) {
            $comment['formatted_date'] = (new Comment())->getFormattedDate($comment['created_at']);
        }

        $view = new View("Security/profile", "front");
        $view->assign("authenticatedUser", $user);
        $view->assign('pages', $pages);
        $view->assign('updateProfileForm', $updateProfileForm->build());
        $view->assign("userComments", $userComments);
        $view->render();
    }


    public function resetPassword(): void {

        if (isset($_GET['id'])) {
            $userId = intval($_GET['id']);
            $user = (new User())->findOneById($userId);
        } else {
            header("impossible de récupérer l'user", true, 500);
            header('Location: /500');
            exit();
        }

        $view = new View('Users/reset-password', 'back');
        $view->assign('user', $user);
        $view->render();
    }

    public function sendResetPassword(): void {
        if (isset($_GET['id'])) {
            $userId = intval($_GET['id']);
            $user = (new User())->findOneById($userId);
        } else {
            header("impossible de récupérer l'user", true, 500);
            header('Location: /500');
            exit();
        }
        if($_SESSION['user_id'] == $userId) {

            $resetToken = md5(uniqid(rand(), true));
            $resetTokenCreatedAt = new \DateTime();
            $resetTokenCreatedAtFormatted = $resetTokenCreatedAt->format('Y-m-d H:i:s');

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

            $user->setResetToken($resetToken);
            $user->setTokenExpiration($resetTokenCreatedAtFormatted);
            $user->save();

            $resetPasswordURL = $_ENV['BASE_URL'] . '/resetPassword?email=' . urlencode($user->getEmail()) . '&code=' . $resetToken;
            $phpmailer->isHTML(true);
            $phpmailer->Subject = 'Bonjour '. $user->getFirstname() .' !';
            $phpmailer->Body    = '<h1>Voici le lien pour changer votre mot de passe</h1><p>Cliquez sur le lien ci-dessous pour changer votre mot de passe</p><a href="' . $resetPasswordURL . '">Cliquez ici</a><p>Si le lien ne s\'affiche pas correctement, vous pouvez coller ce lien dans votre URL :</p>' .$resetPasswordURL;
            $phpmailer->AltBody = 'Veuillez activer votre HTML pour accéder au code de changement de mot de passe';

            if ($phpmailer->send()) {
                header("Message successuflly sent", true, 200);
                echo 'Le message a bien été envoyé';
            } else {
                header("Le message n\a pas pu être envoyé", true, 500);
                header('Location: /500');
                exit();
                // erreur : echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
            }
        } else {
            header("Wrong user", true, 403);
            header('Location: /403');
        }
    }

    public function treatResetPassword(): void {
        if(isset($_GET['email']) && isset($_GET['code'])) {
            $resetPasswordCode = $_GET['code'];
            $email = $_GET['email'];

            $user = (new User())->findOneByEmail($email);

            if($user->getResetToken() === $resetPasswordCode) {
                $tokenExpiration = new \DateTime($user->getTokenExpiration());
                $now = new \DateTime();

                $diff = $now->diff($tokenExpiration);
                $hours = $diff->h + ($diff->days * 24);

                if($hours < 12) {
                    $updatePasswordForm = new Form("ResetPassword");

                    if($updatePasswordForm->isSubmitted() && $updatePasswordForm->isValid()) {
                        $user->setPassword($_POST['password']);
                        $user->setResetToken(null);
                        $user->setTokenExpiration(null);
                        $user->save();
                        header('Location: ' . $_ENV['BASE_URL'] . '/');
                    }

                    $view = new View('Users/reset-password-interface', 'front');
                    $view->assign('updatePasswordForm', $updatePasswordForm->build());
                    $view->render();
                } else {
                    header("Le code de réinitialisation a expiré, veuillez demander un nouveau lien", true, 403);
                    header('Location: /403');
                    exit();
                }
            } else {
                header("Votre code de changement de mot de passe n'est pas valide", true, 403);
                header('Location: /403');
                exit();
            }
        } else {
            header("Impossible de récupérer les informations d'utilisateur", true, 500);
            header('Location: /500');
            exit();
        }
    }

    private function emailValidation(User $user): void {
        if ($_SESSION['user_id'] == $user->getId()) {
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
                header("Message successuflly sent", true, 200);
                echo 'Le message a bien été envoyé';
            } else {
                header("Le message n\a pas pu être envoyé", true, 500);
                header('Location: /500');
                exit();
                // Logs erreur : echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
            }
        } else {
            header("Wrong user", true, 403);
            header('Location: /403');
        }
    }

    public function accountVerification(): void {
        if (isset($_GET['email']) && isset($_GET['code'])) {
            $email = $_GET['email'];
            $validation_code = $_GET['code'];
            $user = (new User())->findOneByEmail($email);

            if ($user && $user->getValidationCode() === $validation_code) {
                if ($user->getStatus() !== 0) {
                    header('Location: /');
                } else {
                    $user->setStatus(1);
                    $user->setValidationCode(null);
                    $user->save();
                    header("Compte validé avec succes", true, 200);
                    echo "Votre compte a été confirmé avec succès! Vous pouvez fermer cette fenêtre et aller sur l'écran de connexion.";
                }
            } else {
                header("Code de validation invalide ou adresse email incorrecte.", true, 500);
                header('Location: /500');
                exit();
            }
        } else {
            header("code de validation ou adresse email non fournis.", true, 500);
            header('Location: /500');
            exit();
        }
    }

    public function predelete(): void {

        if (isset($_GET['id'])) {
            $userId = intval($_GET['id']);
            $user = (new User())->findOneById($userId);
        } else {
            header("impossible de récupérer l'utilisateur", true, 500);
            header('Location: /500');
            exit();
        }

        $view = new View('Security/delete', 'front');
        $view->assign('user', $user);
        $view->render();
    }

    public function delete(): void
    {
        if (isset($_GET['id'])) {
            $userIdToDelete = intval($_GET['id']);
            $userToDelete = (new User())->findOneById($userIdToDelete);
            
            if ($_SESSION['user_id'] == $userIdToDelete ) {
                if ($userToDelete) {
                    $userToDelete->delete();
                    unset($_SESSION['user_id']);
                    session_destroy();
                    header('Location: /');
                    exit();
                } else {
                    header("Utilisateur non trouvé trouvé", true, 500);
                    header('Location: /500');
                    exit();
                }
            } else {
                header("UNAUTHORIZED", true, 401);
                header('Location: /401');
                exit();
            }
        } else {
            header("ID utilisateur non spécifié", true, 500);
            header('Location: /500');
            exit();
        }
    }

}
