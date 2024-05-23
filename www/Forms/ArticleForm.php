<?php
namespace App\Forms;
class ArticleForm
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Créer un article"
            ],
            "inputs"=>[
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "placeholder"=>"Titre de l&apos;article",
                    "label"=>"Titre",
                    "required"=>true,
                    "error"=>"Le titre de l'article doit faire entre 2 et 50 caractères"
                ],
                "description"=>[
                    "type"=>"textarea",
                    "max"=>50,
                    "placeholder"=>"Description de l'article",
                    "label"=>"Description",
                    "required"=>false,
                    "error"=>"La description ne peut pas faire plus de 50 caracteres"
                ],
                "content"=>[
                    "type"=>"textarea",
                    "placeholder"=>"Entrez ici le contenu de l'article",
                    "label"=>"Contenu",
                    "required"=>true,
                    "error"=>"La description de la page ne peut pas faire plus de 255 caractères"
                ]
            ]

        ];
    }
}