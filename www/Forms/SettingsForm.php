<?php
namespace App\Forms;

class SettingsForm
{
    public static function getConfig(array $data = []): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Valider mes préférences"
            ],
            "inputs"=>[
                "color"=>[
                    "type"=>"color",
                    "label"=>"Couleur Principale",
                    "value" => $data['color'] ?? $_ENV["BASE_COLOR"]
                ],
                "font" => [
                    "type" => "select",
                    "options"=>[
                        "Roboto" => "Roboto",
                        "Times New Roman" => "Times New Roman",
                        "Arial" => "Arial",
                        "Helvetica" => "Helvetica",
                        "Calibri" => "Calibri"
                    ],
                    "value" => $data['font'] ?? ''
                ]
            ]
        ];
    }
}
