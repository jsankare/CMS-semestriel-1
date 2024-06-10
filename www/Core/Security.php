<?php
namespace App\Core;
class Security {
    public function isLogged(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function hasRole(int $requiredRole): bool
    {
        if (!$this->isLogged()) {
            return false;
        }

        $userRole = $_SESSION['user_status'];

        return $userRole >= $requiredRole;
    }
}