<?php

namespace App\Query\Comment;

use App\Query\BaseQueryFactory;
use Doctrine\DBAL\Connection;

final class CommentQueryFactory extends BaseQueryFactory
{
    public static function createQuery(string $strategy, Connection $dbalConnection)
    {
        switch (strtolower($strategy)) {
            case self::DBAL:
                return new DbalCommentQuery($dbalConnection);
            default:
                throw new \InvalidArgumentException('Unsupported strategy: ' . $strategy);
        }
    }
}
