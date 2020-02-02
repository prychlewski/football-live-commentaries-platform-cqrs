<?php

namespace App\Handler\Comment;

use App\Command\Comment\CreateCommentCommand;
use App\Command\Comment\UpdateCommentCommand;
use App\Entity\FootballMatch;
use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;

class UpdateCommentHandler
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function handle(UpdateCommentCommand $command): void
    {
        /** @var Comment $comment */
        $comment = $this->commentRepository->findOneById($command->getCommentId());
        $comment->setContent($command->getContent());

        $this->commentRepository->update($comment);
    }
}
