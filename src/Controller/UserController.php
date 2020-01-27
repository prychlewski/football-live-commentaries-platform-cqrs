<?php

namespace App\Controller;

use App\Command\User\CreateAdministrationUserCommand;
use App\Command\User\CreateRegularUserCommand;
use App\Model\Request\UserRequestModel;
use App\Query\User\UserQuery;
use FOS\RestBundle\Controller\Annotations as Rest;
use League\Tactician\CommandBus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class UserController extends BaseController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Rest\Post("/user/register", name="user_register")
     * @ParamConverter("userRequestModel", converter="fos_rest.request_body")
     */
    public function register(UserRequestModel $userRequestModel, ConstraintViolationListInterface $validationErrors)
    {
        $this->handleErrors($validationErrors);

        $createRegularUserCommand = new CreateRegularUserCommand($userRequestModel);
        $this->commandBus->handle($createRegularUserCommand);

        return $this->redirectToRoute(
            'api_auth_login',
            [
                'username' => $userRequestModel->getUsername(),
                'password' => $userRequestModel->getPassword(),
            ],
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }

    /**
     * @Rest\Post("/user/admin", name="user_add_admin")
     * @ParamConverter("userRequestModel", converter="fos_rest.request_body")
     *
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function addAdmin(
        UserQuery $userQuery,
        UserRequestModel $userRequestModel,
        ConstraintViolationListInterface $validationErrors
    ) {
        $this->handleErrors($validationErrors);

        $createAdministrationUserCommand = new CreateAdministrationUserCommand($userRequestModel);
        $this->commandBus->handle($createAdministrationUserCommand);

        $userView = $userQuery->getByUsername($userRequestModel->getUsername());

        return $this->view($userView);
    }

    /**
     * @Rest\Get("/me", name="user_me")
     */
    public function me(UserQuery $userQuery)
    {
        $sessionUser = $this->getUser();

        // Workaround for in_memory provider
        if (!method_exists($sessionUser, 'getId')) {
            return $this->view($sessionUser);
        }

        $userId = $sessionUser->getId();
        $userView = $userQuery->getById($userId);

        return $this->view($userView);
    }
}
