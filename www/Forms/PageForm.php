<?php
namespace App\Forms;

class PageForm
{
    public static function getConfig(array $data = []): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Enregister ma page"
            ],
            "inputs"=>[
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "placeholder"=>"Titre de la page",
                    "label"=>"Titre",
                    "required"=>true,
                    "error"=>"Le titre de la page doit faire entre 2 et 50 caractères",
                    "value" => $data['title'] ?? ''
                ],
                "description" => [
                    "type" => "text",
                    "max" => 50,
                    "placeholder" => "Description de la page",
                    "label" => "Description",
                    "required" => false,
                    "error" => "La description ne peut pas faire plus de 50 caractères",
                    "value" => $data['description'] ?? ''
                ],
                "content"=>[
                    "type"=>"textarea",
                    "placeholder"=>"Entrez ici le contenu de la page",
                    "label"=>"Contenu",
                    "required"=>true,
                    "value" => $data['content'] ?? ''
                ],
                "is_main" => [
                    "type" => "checkbox",
                    "label" => "Définir comme page principale",
                    "value" => 0,
                    //"required" => false,
                    "checked" => isset($data['is_main']) && $data['is_main']
                    
                ]
            ]
        ];
    }
}
