<?php

namespace App\Query\FootballMatch;

use App\Exception\FootballMatchNotFoundException;
use App\Model\Request\FootballMatchRequestModel;
use App\View\FootballMatchView;
use DateTime;
use Doctrine\DBAL\Connection;

class DbalFootballMatchQuery implements FootballMatchQuery
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getById(int $footballMatchId): FootballMatchView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder->select(
            'fm.id',
            'fm.host_team_id',
            'fm.guest_team_id',
            'fm.date',
            'fm.host_points',
            'fm.guest_points')
            ->from('football_match', 'fm')
            ->where('fm.id = :footballMatchId')
            ->setParameter('footballMatchId', $footballMatchId)
            ->execute();
        $footballMatchData = $statement->fetch();

        return new FootballMatchView($footballMatchData);
    }

    public function getByTeamsIdsAndDate(int $hostTeamId, int $guestTeamId, DateTime $date): FootballMatchView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder->select(
            'fm.id',
            'fm.host_team_id',
            'fm.guest_team_id',
            'fm.date',
            'fm.host_points',
            'fm.guest_points')
            ->from('football_match', 'fm')
            ->where('fm.host_team_id = :host_team_id')
            ->setParameter('host_team_id', $hostTeamId)
            ->andWhere('fm.guest_team_id = :guest_team_id')
            ->setParameter('guest_team_id', $guestTeamId)
            ->andWhere('fm.date = :date')
            ->setParameter('date', $date->format('Y-m-d H:i:s'))
            ->execute();
        $footballMatchData = $statement->fetch();

        return new FootballMatchView($footballMatchData);
    }

    public function getByRequestModel(FootballMatchRequestModel $footballMatchRequestModel): FootballMatchView
    {
        return $this->getByTeamsIdsAndDate(
            $footballMatchRequestModel->getHostTeamId(),
            $footballMatchRequestModel->getGuestTeamId(),
            $footballMatchRequestModel->getDate()
        );
    }
}
