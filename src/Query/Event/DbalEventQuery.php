<?php

namespace App\Query\Event;

use App\Exception\EventNotFoundException;
use App\Model\Request\EventRequestModel;
use App\View\EventView;
use DateTime;
use Doctrine\DBAL\Connection;

class DbalEventQuery implements EventQuery
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getById(int $teamId): EventView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder->select(
            'e.id',
            'e.host_team_id',
            'e.guest_team_id',
            'e.date',
            'e.host_points',
            'e.guest_points')
            ->from('event', 'e')
            ->where('e.id = :eventId')
            ->setParameter('eventId', $teamId)
            ->execute();
        $eventData = $statement->fetch();

        return new EventView($eventData);
    }

    public function getByTeamsIdsAndDate(int $hostTeamId, int $guestTeamId, DateTime $date): EventView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder->select(
            'e.id',
            'e.host_team_id',
            'e.guest_team_id',
            'e.date',
            'e.host_points',
            'e.guest_points')
            ->from('event', 'e')
            ->where('e.host_team_id = :host_team_id')
            ->setParameter('host_team_id', $hostTeamId)
            ->andWhere('e.guest_team_id = :guest_team_id')
            ->setParameter('guest_team_id', $guestTeamId)
            ->andWhere('e.date = :date')
            ->setParameter('date', $date->format('Y-m-d H:i:s'))
            ->execute();
        $eventData = $statement->fetch();

        return new EventView($eventData);
    }

    public function getByRequestModel(EventRequestModel $eventRequestModel): EventView
    {
        return $this->getByTeamsIdsAndDate(
            $eventRequestModel->getHostTeamId(),
            $eventRequestModel->getGuestTeamId(),
            $eventRequestModel->getDate()
        );
    }
}
