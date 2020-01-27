<?php

namespace App\Controller;

use App\Command\EventComment\CreateEventCommentCommand;
use App\Command\EventComment\DeleteEventCommentCommand;
use App\Command\EventComment\UpdateEventCommentCommand;
use App\Model\Request\EventCommentRequestModel;
use App\Query\EventComment\EventCommentQuery;
use FOS\RestBundle\Controller\Annotations\Route;
use League\Tactician\CommandBus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class RelationController extends BaseController
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
     * @Route("/relation/event/{eventId}", name="event_comment_add",  methods={"POST"})
     * @ParamConverter("eventCommentRequestModel", converter="fos_rest.request_body")
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addAction(
        int $eventId,
        EventCommentQuery $eventCommentQuery,
        EventCommentRequestModel $eventCommentRequestModel,
        ConstraintViolationListInterface $validationErrors
    ) {
        $this->handleErrors($validationErrors);

        $createEventCommentCommand = new CreateEventCommentCommand($eventId, $eventCommentRequestModel);
        $this->commandBus->handle($createEventCommentCommand);

        $eventComment = $eventCommentQuery->getLastByEventId($eventId);

        return $this->view($eventComment);
    }

    /**
     * @Route("/relation/{commentId}", name="event_comment_edit",  methods={"PATCH"})
     * @ParamConverter("eventCommentRequestModel", converter="fos_rest.request_body")
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editAction(
        int $commentId,
        EventCommentQuery $eventCommentQuery,
        EventCommentRequestModel $eventCommentRequestModel,
        ConstraintViolationListInterface $validationErrors
    ) {
        $this->handleErrors($validationErrors);

        $updateEventCommentCommand = new UpdateEventCommentCommand($commentId, $eventCommentRequestModel);
        $this->commandBus->handle($updateEventCommentCommand);

        $eventComment = $eventCommentQuery->getById($commentId);

        return $this->view($eventComment);
    }

    /**
     * @Route("/relation/{commentId}", name="event_comment_delete",  methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteAction(int $commentId)
    {
        $deleteEventCommentCommand = new DeleteEventCommentCommand($commentId);
        $this->commandBus->handle($deleteEventCommentCommand);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/relation/event/{eventId}/complete", name="event_comments_view",  methods={"GET"})
     *
     * @Security("is_granted('ROLE_USER')")
     */
    public function viewAction(int $eventId, EventCommentQuery $eventCommentQuery)
    {
        $eventComments = $eventCommentQuery->getCommentsByEventId($eventId);

        return $this->view($eventComments);
    }
}
