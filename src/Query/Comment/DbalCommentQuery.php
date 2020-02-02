<?php

namespace App\Query\Comment;

use App\Exception\CommentNotFoundException;
use App\View\CommentView;
use DateTime;
use Doctrine\DBAL\Connection;

class DbalCommentQuery implements CommentQuery
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getById(int $commentId): CommentView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder->select('c.id, c.content, c.date')
            ->from('comment', 'c')
            ->where('c.id = :commentId')
            ->setParameter('commentId', $commentId)
            ->execute();
        $commentData = $statement->fetch();

        return $this->createCommentView($commentData);
    }

    public function getLastByFootballMatchId(int $footballMatchId): CommentView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder->select('c.id, c.content, c.date')
            ->from('comment', 'c')
            ->where('c.football_match_id = :footballMatch')
            ->setParameter('footballMatch', $footballMatchId)
            ->orderBy('c.id', 'DESC')
            ->setMaxResults(1)
            ->execute();
        $commentData = $statement->fetch();

        return $this->createCommentView($commentData);
    }

    public function getCommentsByFootballMatchId(int $footballMatchId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder->select('c.id, c.content, c.date')
            ->from('comment', 'c')
            ->where('c.football_match_id = :footballMatch')
            ->setParameter('footballMatch', $footballMatchId)
            ->orderBy('c.id', 'DESC')
            ->execute();

        $comments = [];
        while ($commentData = $statement->fetch()) {
            $comments[] = $this->createCommentView($commentData);
        }

        return $comments;
    }

    private function createCommentView(&$commentData): CommentView
    {
        if (!$commentData) {
            throw new CommentNotFoundException();
        }

        return new CommentView(
            $commentData['id'],
            $commentData['content'],
            new DateTime($commentData['date'])
        );
    }
}
