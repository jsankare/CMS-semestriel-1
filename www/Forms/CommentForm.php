<?php
namespace App\Forms;

class CommentForm
{
    public static function getConfig(array $data = []): array
    {
        return [
            "config" => [
                "action" => "",
                "method" => "POST",
                "submit" => "Ajouter un commentaire"
            ],
            "inputs" => [
                "content" => [
                    "type" => "textarea",
                    "placeholder" => "Entrez votre commentaire ici*",
                    "label" => "Commentaire",
                    "required" => true,
                    "error" => "Le commentaire ne peut pas être vide",
                    "value" => $data['content'] ?? ''
                ]
            ]
        ];
    }
}
