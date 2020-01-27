<?php

namespace App\Handler\User;

use App\Entity\User;

abstract class AbstractCreateUserHandler
{
    protected function prepareUser(string $username, string $password, array $roles)
    {
        // Unfortunate FOSRest user handling
        $user = new User();
        $user
            ->setUsername($username)
            ->setPlainPassword($password)
            ->setEnabled(true)
            ->setRoles($roles)
            ->setSuperAdmin(false);

        return $user;
    }
}
