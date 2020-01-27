<?php

namespace App\Query\Team;

use App\Exception\TeamNotFoundException;
use App\View\TeamView;
use Doctrine\DBAL\Connection;

class DbalTeamQuery implements TeamQuery
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getById(int $teamId): TeamView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder->select('t.id, t.name')
            ->from('team', 't')
            ->where('t.id = :teamId')
            ->setParameter('teamId', $teamId)
            ->execute();
        $teamData = $statement->fetch();

        return $this->createTeamView($teamData);
    }

    public function getByTeamName(string $teamName): TeamView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder->select('t.id, t.name')
            ->from('team', 't')
            ->where('t.name = :teamName')
            ->setParameter('teamName', $teamName)
            ->execute();
        $teamData = $statement->fetch();

        return $this->createTeamView($teamData);
    }

    private function createTeamView(&$teamData): TeamView
    {
        if (!$teamData) {
            throw new TeamNotFoundException();
        }

        return new TeamView(
            $teamData['id'],
            $teamData['name']
        );
    }
}
