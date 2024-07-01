<?php
namespace App\Controller;

use App\Core\Form;
use App\Core\View;
use App\Models\Page;
use App\Models\Image;

class GalleryController
{
    public function create(): void
    {
        $pages = (new Page())->findAll();
        $galleryForm = new Form('Gallery');

        if ($galleryForm->isSubmitted() && $galleryForm->isValid()) {

            $ext = (new \SplFileInfo($_FILES["image"]["name"]))->getExtension();

            // might be error with creating folder rights, fixed using "chmod -R 777 www/Public"
            $uploadDir = '/var/www/html/www/Public/uploads/';
            if(is_dir($uploadDir)) {
            } else {
                if (!mkdir($uploadDir, 0777, true)) {
                    header("Dossier non créé ", true, 500);
                    header('Location: /500');
                    exit();
                } else {
                    header("Dossier créé", true, 200);
                }
            }
            $uploadFile = $uploadDir . uniqid() . '.' . $ext;

            // Check MIME type
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($_FILES['image']['tmp_name']);

            $allowedMimeTypes = ['image/png', 'image/jpeg', 'image/jpg'];
            if (!in_array($mimeType, $allowedMimeTypes)) {
                header("Erreur, seulement les PNG, JPEG & JPG sont acceptés", true, 500);
                header('Location: /500');
                exit();
            }

            // Move file du tmp au dossier uploads
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                header("Fichier uploadé avec succes", true, 200);
            } else {
                header("Fichier non créé", true, 500);
                header('Location: /500');
                exit();
            }

            $image = new Image();
            $image->setTitle($_POST['title']);
            $image->setDescription($_POST['description']);
            $image->setLink($uploadFile);
            $image->save();

            header('Location: /gallery/list');
            exit();
        }

        $view = new View('Gallery/create', 'back');
        $view->assign('galleryForm', $galleryForm->build());
        $view->assign('pages', $pages);
        $view->render();
    }

    public function home(): void {
        $pages = (new Page())->findAll();

        $imageModel = new Image();
        $images = $imageModel->findAll();

        $view = new View('Gallery/home', 'front');
        $view->assign('images', $images);
        $view->assign('pages', $pages);
        $view->render();
    }

    public function list(): void {
        $pages = (new Page())->findAll();
        
        $imageModel = new Image();
        $images = $imageModel->findAll();

        $view = new View('Gallery/list', 'back');
        $view->assign('images', $images);
        $view->assign('pages', $pages);
        $view->render();
    }

    public function delete(): void {
        if (isset($_GET['id'])) {
            $imageId = intval($_GET['id']);
            $image = (new Image())->findOneById($imageId);

            if ($image) {
                $imagePath = $image->getLink();

                if (file_exists($imagePath)) {
                    if (unlink($imagePath)) {
                        header("Fichier supprimé avec succes", true, 200);
                    } else {
                        header("Internal Server Error", true, 500);
                        header('Location: /500');
                        exit();
                    }
                } else {
                    header("File does not exist", true, 404);
                    header('Location: /404');
                    // Redirige ici par defaut en local a cause du changement de pathing
                    exit();
                }

                $image->delete();
                header('Location: /gallery/list');
                exit();
            } else {
                header("Image non trouvée", true, 404);
                header('Location: /404');
                exit();
            }
        } else {
            header("Image ID non spécifié", true, 500);
            header('Location: /500');
            exit();
        }
    }

    public function predelete(): void {

        if (isset($_GET['id'])) {
            $imageId = intval($_GET['id']);
            $image = (new Image())->findOneById($imageId);
        } else {
            header("impossible de récupérer l'image", true, 500);
            header('Location: /500');
            exit();
        }

        $view = new View('Gallery/delete', 'back');
        $view->assign('image', $image);
        $view->render();
    }

    public function edit(): void
    {
        if (isset($_GET['id'])) {
            $imageId = intval($_GET['id']);
            $image = (new Image())->findOneById($imageId);

            if ($image) {
                $imageForm = new Form("Gallery");
                $imageForm->setValues([
                    'title' => $image->getTitle(),
                    'description' => $image->getDescription(),
                    'image' => $image->getLink(),
                ]);

                if ($imageForm->isSubmitted() && $imageForm->isValid()) {

                    $ext = (new \SplFileInfo($_FILES["image"]["name"]))->getExtension();

                    // might be error with creating folder rights, fixed using "chmod -R 777 www/Public"
                    $uploadDir = '/var/www/html/www/Public/uploads/';
                    if(is_dir($uploadDir)) {
                    } else {
                        if (!mkdir($uploadDir, 0777, true)) {
                            header("Problem creating folder", true, 500);
                            header('Location: /500');
                            exit();
                        } else {
                            header("Folder created", true, 200);
                        }
                    }
                    $uploadFile = $uploadDir . uniqid() . '.' . $ext;

                    // Check MIME type
                    $finfo = new \finfo(FILEINFO_MIME_TYPE);
                    $mimeType = $finfo->file($_FILES['image']['tmp_name']);

                    $allowedMimeTypes = ['image/png', 'image/jpeg', 'image/jpg'];
                    if (!in_array($mimeType, $allowedMimeTypes)) {
                        header("Erreur, seulement les PNG, JPEG & JPG sont acceptés", true, 500);
                        header('Location: /500');
                        exit();
                    }

                    // Move file du tmp au dossier uploads
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                        header("File is valid, and was successfully uploaded.\n", true, 200);
                    } else {
                        header("Impossible de déplacer le fichier dans le bon dossier", true, 500);
                        header('Location: /500');
                        exit();
                    }

                    $image->setTitle($_POST['title']);
                    $image->setDescription($_POST['description']);
                    $image->setLink($uploadFile);
                    $image->save();
                    header("Image editée", true, 200);
                    header('Location: /gallery/list');
                    exit();
                }

                $view = new View("Gallery/edit", "back");
                $view->assign('imageForm', $imageForm->build());
                $view->assign('image', $image);
                $view->render();
            } else {
                header("Image non trouvée", true, 404);
                header('Location: /404');
                exit();
            }
        } else {
            header("ID Image non spécifié", true, 500);
            header('Location: /500');
            exit();
        }
    }

}