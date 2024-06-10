<?php
namespace App\Forms;
class UpdateUserForm
{
    public static function getConfig(array $data = []): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Valider"
            ],
            "inputs"=>[
                "firstname"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "placeholder"=>"Entrez le prénom",
                    "error"=>"Votre prénom doit faire entre 2 et 50 caractères",
                    "value" => $data['title'] ?? ''
                ],
                "lastname"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "placeholder"=>"Entrez le nom",
                    "error"=>"Votre nom doit faire entre 2 et 50 caractères",
                    "value" => $data['title'] ?? ''
                ],
                "email"=>[
                    "type"=>"email",
                    "min"=>8,
                    "max"=>320,
                    "placeholder"=>"Entre l&apos;email",
                    "error"=>"Votre email doit faire entre 8 et 320 caractères",
                    "value" => $data['title'] ?? ''
                ],
                "role"=>[
                    "type"=> "select",
                    "options"=>[
                        0 => "Invité",
                        1 => "Utilisateur",
                        2 => "Éditeur",
                        3 => "Modérateur",
                        4 => "Administrateur"
                    ],
                    "value" => $data['status'] ?? 0
                ]
            ]
        ];
    }
}