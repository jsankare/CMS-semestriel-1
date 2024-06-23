<?php

namespace App\Core;

use App\Forms\RegisterForm;

class Form
{
    private $config;
    private $errors = [];
    private $values = [];

    public function __construct(string $name)
    {
        if (!file_exists("../Forms/{$name}Form.php")) {
            die("Le form " . $name . "Form.php n'existe pas dans le dossier ../Forms");
        }
        include "../Forms/{$name}Form.php";
        $name = "App\\Forms\\{$name}Form";
        $this->config = $name::getConfig();
    }

    public function setValues(array $values): void
    {
        foreach ($values as $key => $value) {
            if (isset($this->config["inputs"][$key])) {
                $this->config["inputs"][$key]['value'] = $value;
            }
        }
    }

    public function build(): string
    {
        $html = "";

        if (!empty($this->errors)) {
            $html .= "<ul>";
            foreach ($this->errors as $error) {
                $html .= "<li>" . $error . "</li>";
            }
            $html .= "</ul>";
        }

        $enctype = isset($this->config["config"]["enctype"]) ? "enctype='{$this->config["config"]["enctype"]}'" : '';
        $html .= "<form action='{$this->config["config"]["action"]}' method='{$this->config["config"]["method"]}' {$enctype}>";

        foreach ($this->config["inputs"] as $name => $input) {
            $html .= "<div class='input--wrapper'>";

            if (isset($input["label"])) {
                $html .= "<label class='label label--{$name}' for='{$name}'>{$input["label"]}</label>";
            }

            if ($input["type"] == "textarea" && $name == "content") {
                $content = isset($input["value"]) && !empty($input["value"]) ? $input["value"] : '';
                $html .= "<div id='editor'>{$content}</div>";
                $html .= "<input type='hidden' name='{$name}' id='hidden_{$name}' value=''>";
            } else if ($input["type"] == "textarea") {
                $html .= "<textarea class='input input--{$name}' id='{$name}' name='{$name}'";
                if (isset($input["placeholder"])) {
                    $html .= " placeholder='" . htmlspecialchars($input["placeholder"]) . "'";
                }
                if (isset($input["required"]) && $input["required"]) {
                    $html .= " required";
                }
                $html .= ">";
                if (isset($input["value"])) {
                    $html .= htmlspecialchars($input["value"]);
                }
                $html .= "</textarea>";
            } else if ($input["type"] == "select") {
                $html .= "<select class='input input--{$name}' id='{$name}' name='{$name}'>";
                foreach ($input["options"] as $value => $option) {
                    $selected = isset($input["value"]) && $input["value"] == $value ? " selected" : "";
                    $html .= "<option value='" . htmlspecialchars($value) . "'{$selected}>" . htmlspecialchars($option) . "</option>";
                }
                $html .= "</select>";
            } else {
                $html .= "<input class='input input--{$name}' type='{$input["type"]}' name='{$name}'";
                if (isset($input["placeholder"])) {
                    $html .= " placeholder='{$input["placeholder"]}'";
                }
                if (isset($input["required"]) && $input["required"]) {
                    $html .= " required";
                }
                if (isset($input["value"])) {
                    $html .= " value='" . htmlspecialchars($input["value"]) . "'";
                }
                $html .= ">";
            }

            $html .= "</div>";  // Close the input--wrapper div
        }

        $html .= "<input class='input--submit' type='submit' value='" . htmlentities($this->config["config"]["submit"]) . "'>";
        $html .= "</form>";

        return $html;
    }

    public function isSubmitted(): bool
    {
        if ($this->config["config"]["method"] == "POST" && !empty($_POST)) {
            return true;
        } else if ($this->config["config"]["method"] == "GET" && !empty($_GET)) {
            return true;
        } else {
            return false;
        }
    }

    public function isValid(): bool
    {
        $fileInputs = array_filter($this->config['inputs'], function ($input) {
            return $input['type'] === 'file';
        });
        //Est-ce que j'ai exactement le meme nb de champs
        if (count($this->config["inputs"]) - count($fileInputs) != count($_POST)) {
            $this->errors[] = "Tentative de Hack, le compte n'est pas bon";
        }

        foreach ($_POST as $name => $dataSent) {
            //Est-ce qu'il s'agit d'un champ que je lui ai donné ?
            if (!isset($this->config["inputs"][$name])) {
                $this->errors[] = "Tentative de Hack, le champ " . $name . " n'est pas autorisé";
            }

            //Est ce que ce n'est pas vide si required
            if (isset($this->config["inputs"][$name]["required"]) && empty($dataSent)) {
                $this->errors[] = "Le champ " . $name . " ne doit pas être vide";
            }

            //Est ce que le min correspond
            if (isset($this->config["inputs"][$name]["min"])
                && strlen($dataSent) < $this->config["inputs"][$name]["min"]) {
                $this->errors[] = $this->config["inputs"][$name]["error"];
            }

            //Est ce que le max correspond
            if (isset($this->config["inputs"][$name]["max"])
                && strlen($dataSent) > $this->config["inputs"][$name]["max"]) {
                $this->errors[] = $this->config["inputs"][$name]["error"];
            }

            //Est ce que la confirmation correspond
            if (isset($this->config["inputs"][$name]["confirm"]) && $dataSent != $_POST[$this->config["inputs"][$name]["confirm"]]) {
                $this->errors[] = $this->config["inputs"][$name]["error"];
            } else {
                //Est ce que le format email est OK
                if ($this->config["inputs"][$name]["type"] == "email" &&
                    !filter_var($dataSent, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[] = "Le format de l'email est incorrect";
                }
                //Est ce que le format password est OK
                if ($this->config["inputs"][$name]["type"] == "password" &&
                    (!preg_match("#[a-z]#", $dataSent) ||
                        !preg_match("#[A-Z]#", $dataSent) ||
                        !preg_match("#[0-9]#", $dataSent))
                ) {
                    $this->errors[] = $this->config["inputs"][$name]["error"];
                }
            }
        }

        return empty($this->errors); // If true return true
    }
}

