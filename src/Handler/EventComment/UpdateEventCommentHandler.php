<?php

namespace App\Handler\EventComment;

use App\Command\EventComment\CreateEventCommentCommand;
use App\Command\EventComment\UpdateEventCommentCommand;
use App\Entity\Event;
use App\Entity\EventComment;
use App\Repository\EventCommentRepository;
use Doctrine\ORM\EntityManagerInterface;

class UpdateEventCommentHandler
{
    /**
     * @var EventCommentRepository
     */
    private $eventCommentRepository;

    public function __construct(EventCommentRepository $eventCommentRepository)
    {
        $this->eventCommentRepository = $eventCommentRepository;
    }

    public function handle(UpdateEventCommentCommand $command): void
    {
        /** @var EventComment $eventComment */
        $eventComment = $this->eventCommentRepository->findOneById($command->getCommentId());
        $eventComment->setContent($command->getContent());

        $this->eventCommentRepository->update($eventComment);
    }
}
