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
            $uploadDir = '/var/www/html/Public/uploads/';
            if(is_dir($uploadDir)) {
            } else {
                if (!mkdir($uploadDir, 0777, true)) {
                    echo "pb creating folder";
                } else {
                    echo "folder has been created";
                }
            }
            $uploadFile = $uploadDir . uniqid() . '.' . $ext;

            // Check MIME type
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($_FILES['image']['tmp_name']);

            $allowedMimeTypes = ['image/png', 'image/jpeg', 'image/jpg'];
            if (!in_array($mimeType, $allowedMimeTypes)) {
                echo "Erreur, seulement les PNG, JPEG & JPG sont acceptés.";
                die;
            }

            // Move file du tmp au dossier uploads
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                echo "File is valid, and was successfully uploaded.\n";
            } else {
                echo "Possible file upload attack!\n";
                die;
            }

            $image = new Image();
            $image->setTitle($_POST['title']);
            $image->setDescription($_POST['description']);
            $image->setLink($uploadFile);
            $image->save();

        }

        $view = new View('Gallery/create', 'back');
        $view->assign('galleryForm', $galleryForm->build());
        $view->assign('pages', $pages);
        $view->render();
    }

    function home(): void {
        $pages = (new Page())->findAll();
        
        $view = new View('Gallery/home', 'front');
        $view->assign('pages', $pages);
        $view->render();
    }

    function list(): void {
        $pages = (new Page())->findAll();
        
        $imageModel = new Image();
        $images = $imageModel->findAll();

        $view = new View('Gallery/list', 'back');
        $view->assign('images', $images);
        $view->assign('pages', $pages);
        $view->render();
    }

}