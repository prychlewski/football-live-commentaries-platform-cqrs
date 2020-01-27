<?php

namespace App\Query\EventComment;

use App\View\EventCommentView;

interface EventCommentQuery
{
    public function getById(int $eventId): EventCommentView;
    public function getLastByEventId(int $eventId): EventCommentView;
    public function getCommentsByEventId(int $eventId): array;
}
