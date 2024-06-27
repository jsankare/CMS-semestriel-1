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
                "background_color"=>[
                    "type"=>"color",
                    "label"=>"Couleur de fond",
                    "value" => $data['color'] ?? $_ENV["BACKGROUND_COLOR"]
                ],
                "font_color"=>[
                    "type"=>"color",
                    "label"=>"Couleur de police",
                    "value" => $data['color'] ?? $_ENV["FONT_COLOR"]
                ],
                "font_style" => [
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
