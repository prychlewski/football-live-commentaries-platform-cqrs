<?php

namespace App\Handler\Comment;

use App\Command\Comment\CreateCommentCommand;
use App\Entity\FootballMatch;
use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;

class CreateCommentHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->commentRepository = $commentRepository;
    }

    public function handle(CreateCommentCommand $command): void
    {
        $footballMatch = $this->entityManager->getReference(FootballMatch::class, $command->getFootballMatchId());

        $comment = new Comment($footballMatch, $command->getComment(), new \DateTime());

        $this->commentRepository->add($comment);
    }
}
