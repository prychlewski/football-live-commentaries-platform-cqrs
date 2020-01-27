<?php

namespace App\Handler\Team;

use App\Command\Team\CreateTeamCommand;
use App\Entity\Team;
use App\Repository\TeamRepository;

class CreateTeamHandler
{
    /**
     * @var TeamRepository
     */
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function handle(CreateTeamCommand $command): void
    {
        $team = new Team($command->getTeamName());

        $this->teamRepository->add($team);
    }
}
