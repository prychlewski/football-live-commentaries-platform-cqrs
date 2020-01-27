<?php

namespace App\Command\User;

use App\Model\Request\UserRequestModel;

abstract class AbstractCreateUserCommand
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    public function __construct(UserRequestModel $userRequestModel)
    {
        $this->username = $userRequestModel->getUsername();
        $this->password = $userRequestModel->getPassword();
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
