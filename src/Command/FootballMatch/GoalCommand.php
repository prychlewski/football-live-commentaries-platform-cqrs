<?php

namespace App\Command\FootballMatch;

class GoalCommand
{
    /**
     * @var int
     */
    private $footballMatchId;

    /**
     * @var int
     */
    private $teamId;

    public function __construct(int $footballMatchId, int $teamId)
    {
        $this->footballMatchId = $footballMatchId;
        $this->teamId = $teamId;
    }

    /**
     * @return int
     */
    public function getFootballMatchId(): int
    {
        return $this->footballMatchId;
    }

    /**
     * @return int
     */
    public function getTeamId(): int
    {
        return $this->teamId;
    }
}
