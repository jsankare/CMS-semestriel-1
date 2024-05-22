<?php
namespace App\Core;
class Security
{

    public function isLogged(): bool
    {
        return isset($_SESSION['user_id']);
    }


}