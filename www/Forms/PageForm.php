<?php
namespace App\Forms;
class PageForm
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Créer une page"
            ],
            "inputs"=>[
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "placeholder"=>"Titre de la page",
                    "label"=>"Titre",
                    "required"=>true,
                    "error"=>"Le titre de la page doit faire entre 2 et 50 caractères"
                ],
                "content"=>[
                    "type"=>"textarea",
                    "placeholder"=>"Entrez ici une description de la page",
                    "label"=>"Description",
                    "required"=>true,
                    "error"=>"La description de la page ne peut pas faire plus de 255 caractères"
                ]
            ]

        ];
    }
}