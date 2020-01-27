<?php

namespace App\Command\Team;

use App\Model\Request\TeamRequestModel;

abstract class AbstractTeamCommand
{
    /**
     * @var string
     */
    private $teamName;

    public function __construct(TeamRequestModel $teamRequestModel)
    {
        $this->teamName = $teamRequestModel->getName();
    }

    /**
     * @return string
     */
    public function getTeamName(): string
    {
        return $this->teamName;
    }
}
