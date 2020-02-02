<?php

namespace App\Controller;

use App\Command\FootballMatch\CreateFootballMatchCommand;
use App\Command\FootballMatch\DeleteFootballMatchCommand;
use App\Command\FootballMatch\GoalCommand;
use App\Command\FootballMatch\UpdateFootballMatchCommand;
use App\Model\Request\GoalRequestModel;
use App\Model\Request\FootballMatchRequestModel;
use App\Query\FootballMatch\FootballMatchQuery;
use FOS\RestBundle\Controller\Annotations\Route;
use League\Tactician\CommandBus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class FootballMatchController extends BaseController
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
     * @Route("/football-match", name="football_match_add",  methods={"POST"})
     * @ParamConverter("footballMatchRequestModel", converter="fos_rest.request_body")
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addAction(
        FootballMatchRequestModel $footballMatchRequestModel,
        ConstraintViolationListInterface $validationErrors,
        FootballMatchQuery $footballMatchQuery
    ) {
        $this->handleErrors($validationErrors);

        $createFootballMatchCommand = new CreateFootballMatchCommand($footballMatchRequestModel);
        $this->commandBus->handle($createFootballMatchCommand);

        $footballMatchView = $footballMatchQuery->getByRequestModel($footballMatchRequestModel);

        return $this->view($footballMatchView);
    }

    /**
     * @Route("/football-match/{id}", name="football_match_edit",  methods={"PATCH"})
     * @ParamConverter("footballMatchRequestModel", converter="fos_rest.request_body")
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editAction(
        int $id,
        FootballMatchRequestModel $footballMatchRequestModel,
        ConstraintViolationListInterface $validationErrors,
        FootballMatchQuery $footballMatchQuery
    ) {
        $this->handleErrors($validationErrors);

        $updateFootballMatchCommand = new UpdateFootballMatchCommand($id, $footballMatchRequestModel);
        $this->commandBus->handle($updateFootballMatchCommand);

        $footballMatchView = $footballMatchQuery->getById($id);

        return $this->view($footballMatchView);
    }

    /**
     * @Route("/football-match/{id}", name="football_match_delete",  methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteAction(int $id)
    {
        $deleteFootballMatchCommand = new DeleteFootballMatchCommand($id);
        $this->commandBus->handle($deleteFootballMatchCommand);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/football-match/{id}", name="football_match_view",  methods={"GET"})
     */
    public function viewAction(int $id, FootballMatchQuery $footballMatchQuery)
    {
        $footballMatchView = $footballMatchQuery->getById($id);

        return $this->view($footballMatchView);
    }

    /**
     * @Route("/football-match/{footballMatchId}/goal", name="football_match_goal",  methods={"PATCH"})
     * @ParamConverter("goalRequestModel", converter="fos_rest.request_body")
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function scoreAGoalAction(
        int $footballMatchId,
        GoalRequestModel $goalRequestModel,
        ConstraintViolationListInterface $validationErrors
    ) {
        $this->handleErrors($validationErrors);

        $goalCommand = new GoalCommand(
            $footballMatchId,
            $goalRequestModel->getTeamId()
        );
        $this->commandBus->handle($goalCommand);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
