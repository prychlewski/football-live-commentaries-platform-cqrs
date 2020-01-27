<?php

namespace App\Handler\User;

use App\Command\User\CreateRegularUserCommand;
use FOS\UserBundle\Model\UserManagerInterface;

class CreateRegularUserHandler extends AbstractCreateUserHandler
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function handle(CreateRegularUserCommand $command): void
    {
        $user = $this->prepareUser($command->getUsername(), $command->getPassword(), ['ROLE_USER']);

        $this->userManager->updateUser($user, true);
    }
}
