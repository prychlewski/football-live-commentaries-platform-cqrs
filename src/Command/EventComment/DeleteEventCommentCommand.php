<?php

namespace App\Command\EventComment;

class DeleteEventCommentCommand
{
    /**
     * @var int
     */
    private $eventId;

    public function __construct(int $eventId)
    {
        $this->eventId = $eventId;
    }

    /**
     * @return int
     */
    public function getEventId(): int
    {
        return $this->eventId;
    }
}
