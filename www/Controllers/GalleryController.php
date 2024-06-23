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
            $uploadDir = '/var/www/html/Public/uploads/';
            $uploadFile = $uploadDir . uniqid() . '.' . $ext;

            // Is uploaded && right mime type
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

        $view = new View('Gallery/home', 'back');
        $view->assign('galleryForm', $galleryForm->build());
        $view->assign('pages', $pages);
        $view->render();
    }

    function home(): void {
        echo "beuteu";
    }

}