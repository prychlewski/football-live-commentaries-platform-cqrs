<?php

namespace App\Query\EventComment;

use App\Exception\EventCommentNotFoundException;
use App\View\EventCommentView;
use DateTime;
use Doctrine\DBAL\Connection;

class DbalEventCommentQuery implements EventCommentQuery
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getById(int $eventCommentId): EventCommentView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder->select('ec.id, ec.content, ec.date')
            ->from('event_comment', 'ec')
            ->where('ec.id = :eventCommentId')
            ->setParameter('eventCommentId', $eventCommentId)
            ->execute();
        $eventCommentData = $statement->fetch();

        return $this->createEventCommentView($eventCommentData);
    }

    public function getLastByEventId(int $eventId): EventCommentView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder->select('ec.id, ec.content, ec.date')
            ->from('event_comment', 'ec')
            ->where('ec.event_id = :event_id')
            ->setParameter('event_id', $eventId)
            ->orderBy('ec.id', 'DESC')
            ->setMaxResults(1)
            ->execute();
        $eventCommentData = $statement->fetch();

        return $this->createEventCommentView($eventCommentData);
    }

    public function getCommentsByEventId(int $eventId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder->select('ec.id, ec.content, ec.date')
            ->from('event_comment', 'ec')
            ->where('ec.event_id = :event_id')
            ->setParameter('event_id', $eventId)
            ->orderBy('ec.id', 'DESC')
            ->execute();

        $comments = [];
        while($eventCommentData = $statement->fetch()) {
            $comments[] = $this->createEventCommentView($eventCommentData);
        }

        return $comments;
    }

    private function createEventCommentView(&$eventCommentData): EventCommentView
    {
        if (!$eventCommentData) {
            throw new EventCommentNotFoundException();
        }

        return new EventCommentView(
            $eventCommentData['id'],
            $eventCommentData['content'],
            new DateTime($eventCommentData['date'])
        );
    }
}
