<?php

namespace App\Command\Comment;

class DeleteCommentCommand
{
    /**
     * @var int
     */
    private $commentId;

    public function __construct(int $commentId)
    {
        $this->commentId = $commentId;
    }

    /**
     * @return int
     */
    public function getCommentId(): int
    {
        return $this->commentId;
    }
}
