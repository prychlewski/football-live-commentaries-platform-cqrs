<?php

namespace App\Handler\Comment;

use App\Command\Comment\DeleteCommentCommand;
use App\Repository\CommentRepository;

class DeleteCommentHandler
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function handle(DeleteCommentCommand $command): void
    {
        $comment = $this->commentRepository->findOneById($command->getCommentId());

        $this->commentRepository->delete($comment);
    }
}
