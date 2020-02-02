<?php

namespace App\Query\Comment;

use App\View\CommentView;

interface CommentQuery
{
    public function getById(int $commentId): CommentView;
    public function getLastByFootballMatchId(int $footballMatchId): CommentView;
    public function getCommentsByFootballMatchId(int $footballMatchId): array;
}
