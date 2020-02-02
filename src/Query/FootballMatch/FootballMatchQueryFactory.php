<?php

namespace App\Query\FootballMatch;

use App\Query\BaseQueryFactory;
use Doctrine\DBAL\Connection;

final class FootballMatchQueryFactory extends BaseQueryFactory
{
    public static function createQuery(string $strategy, Connection $dbalConnection)
    {
        switch (strtolower($strategy)) {
            case self::DBAL:
                return new DbalFootballMatchQuery($dbalConnection);
            default:
                throw new \InvalidArgumentException('Unsupported strategy: ' . $strategy);
        }
    }
}
