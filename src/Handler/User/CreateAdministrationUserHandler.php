<?php

namespace App\Handler\User;

use App\Command\User\CreateAdministrationUserCommand;
use FOS\UserBundle\Model\UserManagerInterface;

class CreateAdministrationUserHandler extends AbstractCreateUserHandler
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function handle(CreateAdministrationUserCommand $command): void
    {
        $user = $this->prepareUser($command->getUsername(), $command->getPassword(), ['ROLE_ADMIN']);

        $this->userManager->updateUser($user, true);
    }
}
