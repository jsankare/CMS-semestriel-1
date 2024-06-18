<?php
namespace App\Forms;

class GalleryForm
{
    public static function getConfig(array $data = []): array
    {
        return [
            "config" => [
                "action" => "",
                "method" => "POST",
                "enctype" => "multipart/form-data",
                "submit" => "Upload Image"
            ],
            "inputs" => [
                "title" => [
                    "type" => "text",
                    "label" => "Title",
                    "required" => true,
                    "value" => $data['title'] ?? ''
                ],
                "description" => [
                    "type" => "text",
                    "label" => "Description",
                    "required" => true,
                    "value" => $data['description'] ?? ''
                ],
                "image" => [
                    "type" => "file",
                    "label" => "Image",
                    "required" => true
                ]
            ]
        ];
    }
}
