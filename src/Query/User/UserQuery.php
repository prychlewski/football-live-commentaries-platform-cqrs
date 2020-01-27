<?php

namespace App\Query\User;

use App\View\UserView;

interface UserQuery
{
    public function getById(int $userId): UserView;
    public function getByUsername(string $username): UserView;
}
