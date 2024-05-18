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
        // pour ça j'ai dit dans islogged tu m'as dit non dan sla classe / ah non meme pas
        //du coup maintenant security guard n'existe pas, c'est pas ta source pour savoir si tu es logged  / jcomprends pas ta phrase
        // oublie la gestion d'acces fait d'abord l'authentification
        return false;
    }


}