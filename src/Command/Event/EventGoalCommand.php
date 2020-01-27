<?php

namespace App\Command\Event;

class EventGoalCommand
{
    /**
     * @var int
     */
    private $eventId;

    /**
     * @var int
     */
    private $teamId;

    public function __construct(int $eventId, int $teamId)
    {
        $this->eventId = $eventId;
        $this->teamId = $teamId;
    }

    /**
     * @return int
     */
    public function getEventId(): int
    {
        return $this->eventId;
    }

    /**
     * @return int
     */
    public function getTeamId(): int
    {
        return $this->teamId;
    }
}
