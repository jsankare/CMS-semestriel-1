<?php
namespace App\Core;
class Security
{

    public function isLogged(): bool
    {
/*        if($securityGuard == "Guest") {
            echo"Not logged in ";
        } else{
            echo"Admin ";
        }*/
        return false;
    }


}