<?php

namespace App\Controller;

use App\Command\Event\CreateEventCommand;
use App\Command\Event\DeleteEventCommand;
use App\Command\Event\EventGoalCommand;
use App\Command\Event\UpdateEventCommand;
use App\Model\Request\EventGoalIRequestModel; 
use App\Model\Request\EventRequestModel;
use App\Query\Event\EventQuery;
use FOS\RestBundle\Controller\Annotations\Route;
use League\Tactician\CommandBus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class EventController extends BaseController
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
     * @Route("/event", name="event_add",  methods={"POST"})
     * @ParamConverter("eventRequestModel", converter="fos_rest.request_body")
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addAction(
        EventRequestModel $eventRequestModel,
        ConstraintViolationListInterface $validationErrors,
        EventQuery $eventQuery
    ) {
        $this->handleErrors($validationErrors);

        $createEventCommand = new CreateEventCommand($eventRequestModel);
        $this->commandBus->handle($createEventCommand);

        $event = $eventQuery->getByRequestModel($eventRequestModel);

        return $this->view($event);
    }

    /**
     * @Route("/event/{id}", name="event_edit",  methods={"PATCH"})
     * @ParamConverter("eventRequestModel", converter="fos_rest.request_body")
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editAction(
        int $id,
        EventRequestModel $eventRequestModel,
        ConstraintViolationListInterface $validationErrors,
        EventQuery $eventQuery
    ) {
        $this->handleErrors($validationErrors);

        $updateEventCommand = new UpdateEventCommand($id, $eventRequestModel);
        $this->commandBus->handle($updateEventCommand);

        $event = $eventQuery->getById($id);

        return $this->view($event);
    }

    /**
     * @Route("/event/{id}", name="event_delete",  methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteAction(int $id)
    {
        $deleteEventCommand = new DeleteEventCommand($id);
        $this->commandBus->handle($deleteEventCommand);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/event/{id}", name="event_view",  methods={"GET"})
     */
    public function viewAction(int $id, EventQuery $eventQuery)
    {
        $event = $eventQuery->getById($id);

        return $this->view($event);
    }

    /**
     * @Route("/event/{eventId}/goal", name="event_goal",  methods={"PATCH"})
     * @ParamConverter("eventGoalRequestModel", converter="fos_rest.request_body")
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function scoreAGoalAction(
        int $eventId,
        EventGoalIRequestModel $eventGoalRequestModel,
        ConstraintViolationListInterface $validationErrors
    ) {
        $this->handleErrors($validationErrors);

        $eventGoalCommand = new EventGoalCommand(
            $eventId,
            $eventGoalRequestModel->getTeamId()
        );
        $this->commandBus->handle($eventGoalCommand);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
