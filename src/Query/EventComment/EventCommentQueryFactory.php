<?php

namespace App\Query\EventComment;

use App\Query\BaseQueryFactory;
use Doctrine\DBAL\Connection;

final class EventCommentQueryFactory extends BaseQueryFactory
{
    public static function createQuery(string $strategy, Connection $dbalConnection)
    {
        switch (strtolower($strategy)) {
            case self::DBAL:
                return new DbalEventCommentQuery($dbalConnection);
            default:
                throw new \InvalidArgumentException('Unsupported strategy: ' . $strategy);
        }
    }
}
