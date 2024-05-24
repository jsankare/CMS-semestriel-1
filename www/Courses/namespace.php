<?php

namespace App\Controller;
class User {
    public function login()
    {

    }
}
//--------------------------
namespace App\Core;
class User {
    public function getFirstname()
    {

    }
}

//--------------------------

namespace App;
use App\Controller\UserController;
use App\Core\User as UserCore;

new UserController();
new UserCore();