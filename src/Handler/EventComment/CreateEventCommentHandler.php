<?php

namespace App\Handler\EventComment;

use App\Command\EventComment\CreateEventCommentCommand;
use App\Entity\Event;
use App\Entity\EventComment;
use App\Repository\EventCommentRepository;
use Doctrine\ORM\EntityManagerInterface;

class CreateEventCommentHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EventCommentRepository
     */
    private $eventCommentRepository;

    public function __construct(EventCommentRepository $eventCommentRepository, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->eventCommentRepository = $eventCommentRepository;
    }

    public function handle(CreateEventCommentCommand $command): void
    {
        $event = $this->entityManager->getReference(Event::class, $command->getEventId());

        $eventComment = new EventComment($event, $command->getComment(), new \DateTime());

        $this->eventCommentRepository->add($eventComment);
    }
}
