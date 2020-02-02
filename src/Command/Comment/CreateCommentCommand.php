<?php

namespace App\Command\Comment;

use App\Model\Request\CommentRequestModel;

class CreateCommentCommand
{
    /**
     * @var int
     */
    private $footballMatchId;

    /**
     * @var string
     */
    private $comment;

    public function __construct(int $footballMatchId, CommentRequestModel $commentRequestModel)
    {
        $this->footballMatchId = $footballMatchId;
        $this->comment = $commentRequestModel->getContent();
    }

    /**
     * @return int
     */
    public function getFootballMatchId(): int
    {
        return $this->footballMatchId;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }
}
