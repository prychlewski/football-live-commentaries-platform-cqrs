<?php

namespace App\Handler\EventComment;

use App\Command\EventComment\DeleteEventCommentCommand;
use App\Repository\EventCommentRepository;

class DeleteEventCommentHandler
{
    /**
     * @var EventCommentRepository
     */
    private $eventCommentRepository;

    public function __construct(EventCommentRepository $eventCommentRepository)
    {
        $this->eventCommentRepository = $eventCommentRepository;
    }

    public function handle(DeleteEventCommentCommand $command): void
    {
        $eventComment = $this->eventCommentRepository->findOneById($command->getEventId());

        $this->eventCommentRepository->delete($eventComment);
    }
}
