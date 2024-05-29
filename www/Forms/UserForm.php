<?php
namespace App\Forms;
class UserForm
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
                    "required"=>true,
                    "error"=>"Votre prénom doit faire entre 2 et 50 caractères",
                    "value" => $data['title'] ?? ''
                ],
                "lastname"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "placeholder"=>"Entrez le nom",
                    "required"=>true,
                    "error"=>"Votre nom doit faire entre 2 et 50 caractères",
                    "value" => $data['title'] ?? ''
                ],
                "email"=>[
                    "type"=>"email",
                    "min"=>8,
                    "max"=>320,
                    "placeholder"=>"Entre l&apos;email",
                    "required"=>true,
                    "error"=>"Votre email doit faire entre 8 et 320 caractères",
                    "value" => $data['title'] ?? ''
                ],
                "password"=>[
                    "type"=>"password",
                    "placeholder"=>"Entrez le mot de passe",
                    "required"=>true,
                    "error"=>"Votre mot de passe doit faire au minimum 8 caractères avec des lettres minscules, majuscules et des chiffres",
                    "value" => $data['title'] ?? ''
                ],
                "passwordConfirm"=>[
                    "type"=>"password",
                    "placeholder"=>"Confirmation",
                    "required"=>true,
                    "confirm"=>"password",
                    "error"=>"La confirmation ne correspond pas",
                    "value" => $data['title'] ?? ''
                ],
            ]
        ];
    }
}