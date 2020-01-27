<?php

namespace App\Query\User;

use App\Query\BaseQueryFactory;
use Doctrine\DBAL\Connection;

final class UserQueryFactory extends BaseQueryFactory
{
    public static function createQuery(string $strategy, Connection $dbalConnection)
    {
        switch (strtolower($strategy)) {
            case self::DBAL:
                return new DbalUserQuery($dbalConnection);
            default:
                throw new \InvalidArgumentException('Unsupported strategy: ' . $strategy);
        }
    }
}
