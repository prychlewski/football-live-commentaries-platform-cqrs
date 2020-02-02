<?php

namespace App\Command\Comment;

use App\Model\Request\CommentRequestModel;

class UpdateCommentCommand
{
    /**
     * @var int
     */
    private $commentId;

    /**
     * @var string
     */
    private $content;

    public function __construct(int $commentId, CommentRequestModel $commentRequestModel)
    {
        $this->commentId = $commentId;
        $this->content = $commentRequestModel->getContent();
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
