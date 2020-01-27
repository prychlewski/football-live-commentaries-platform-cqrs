<?php

namespace App\Controller;

use App\Command\Team\CreateTeamCommand;
use App\Command\Team\DeleteTeamCommand;
use App\Command\Team\UpdateTeamCommand;
use App\Model\Request\TeamRequestModel;
use App\Query\Team\TeamQuery;
use FOS\RestBundle\Controller\Annotations\Route;
use League\Tactician\CommandBus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class TeamController extends BaseController
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
     * @Route("/team", name="team_add",  methods={"POST"})
     * @ParamConverter("teamRequestModel", converter="fos_rest.request_body")
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addAction(
        TeamRequestModel $teamRequestModel,
        ConstraintViolationListInterface $validationErrors,
        TeamQuery $teamQuery
    ) {
        $this->handleErrors($validationErrors);

        $createTeamCommand = new CreateTeamCommand($teamRequestModel);
        $this->commandBus->handle($createTeamCommand);

        $team = $teamQuery->getByTeamName($teamRequestModel->getName());

        return $this->view($team);
    }

    /**
     * @Route("/team/{id}", name="team_edit",  methods={"PATCH"})
     * @ParamConverter("teamRequestModel", converter="fos_rest.request_body")
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editAction(
        int $id,
        TeamRequestModel $teamRequestModel,
        ConstraintViolationListInterface $validationErrors,
        TeamQuery $teamQuery
    ) {
        $this->handleErrors($validationErrors);

        $updateTeamCommand = new UpdateTeamCommand($id, $teamRequestModel);
        $this->commandBus->handle($updateTeamCommand);

        $team = $teamQuery->getById($id);

        return $this->view($team);
    }

    /**
     * @Route("/team/{id}", name="team_delete",  methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteAction(int $id)
    {
        $deleteTeamCommand = new DeleteTeamCommand($id);
        $this->commandBus->handle($deleteTeamCommand);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/team/{id}", name="team_view",  methods={"GET"})
     */
    public function viewAction(int $id, TeamQuery $teamQuery)
    {
        $team = $teamQuery->getById($id);

        return $this->view($team);
    }
}
