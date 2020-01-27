<?php

namespace App\Command\EventComment;

use App\Model\Request\EventCommentRequestModel;

class UpdateEventCommentCommand
{
    /**
     * @var int
     */
    private $commentId;

    /**
     * @var string
     */
    private $content;

    public function __construct(int $commentId, EventCommentRequestModel $eventCommentRequestModel)
    {
        $this->commentId = $commentId;
        $this->content = $eventCommentRequestModel->getContent();
    }

    /**
     * @return int
     */
    public function getCommentId(): int
    {
        return $this->commentId;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
