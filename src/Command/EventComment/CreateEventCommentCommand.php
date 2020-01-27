<?php

namespace App\Command\EventComment;

use App\Model\Request\EventCommentRequestModel;

class CreateEventCommentCommand
{
    /**
     * @var int
     */
    private $eventId;

    /**
     * @var string
     */
    private $comment;

    public function __construct(int $eventId, EventCommentRequestModel $eventCommentRequestModel)
    {
        $this->eventId = $eventId;
        $this->comment = $eventCommentRequestModel->getContent();
    }

    /**
     * @return int
     */
    public function getEventId(): int
    {
        return $this->eventId;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }
}
