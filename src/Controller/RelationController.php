<?php

namespace App\Controller;

use App\Command\Comment\CreateCommentCommand;
use App\Command\Comment\DeleteCommentCommand;
use App\Command\Comment\UpdateCommentCommand;
use App\Model\Request\CommentRequestModel;
use App\Query\Comment\CommentQuery;
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
     * @Route("/relation/football-match/{footballMatchId}", name="comment_add",  methods={"POST"})
     * @ParamConverter("commentRequestModel", converter="fos_rest.request_body")
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addAction(
        int $footballMatchId,
        CommentQuery $commentQuery,
        CommentRequestModel $commentRequestModel,
        ConstraintViolationListInterface $validationErrors
    ) {
        $this->handleErrors($validationErrors);

        $createCommentCommand = new CreateCommentCommand($footballMatchId, $commentRequestModel);
        $this->commandBus->handle($createCommentCommand);

        $commentView = $commentQuery->getLastByFootballMatchId($footballMatchId);

        return $this->view($commentView);
    }

    /**
     * @Route("/relation/{commentId}", name="comment_edit",  methods={"PATCH"})
     * @ParamConverter("commentRequestModel", converter="fos_rest.request_body")
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editAction(
        int $commentId,
        CommentQuery $commentQuery,
        CommentRequestModel $commentRequestModel,
        ConstraintViolationListInterface $validationErrors
    ) {
        $this->handleErrors($validationErrors);

        $updateCommentCommand = new UpdateCommentCommand($commentId, $commentRequestModel);
        $this->commandBus->handle($updateCommentCommand);

        $commentView = $commentQuery->getById($commentId);

        return $this->view($commentView);
    }

    /**
     * @Route("/relation/{commentId}", name="comment_delete",  methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteAction(int $commentId)
    {
        $deleteCommentCommand = new DeleteCommentCommand($commentId);
        $this->commandBus->handle($deleteCommentCommand);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/relation/football-match/{footballMatchId}/complete", name="comments_view",  methods={"GET"})
     *
     * @Security("is_granted('ROLE_USER')")
     */
    public function viewAction(int $footballMatchId, CommentQuery $commentQuery)
    {
        $comments = $commentQuery->getCommentsByFootballMatchId($footballMatchId);

        return $this->view($comments);
    }
}
