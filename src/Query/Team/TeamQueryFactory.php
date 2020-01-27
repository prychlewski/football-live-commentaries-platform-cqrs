<?php

namespace App\Query\Team;

use App\Query\BaseQueryFactory;
use Doctrine\DBAL\Connection;

final class TeamQueryFactory extends BaseQueryFactory
{
    public static function createQuery(string $strategy, Connection $dbalConnection)
    {
        switch (strtolower($strategy)) {
            case self::DBAL:
                return new DbalTeamQuery($dbalConnection);
            default:
                throw new \InvalidArgumentException('Unsupported strategy: ' . $strategy);
        }
    }
}
