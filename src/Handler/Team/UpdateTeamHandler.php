<?php

namespace App\Handler\Team;

use App\Command\Team\UpdateTeamCommand;
use App\Repository\TeamRepository;

class UpdateTeamHandler
{
    /**
     * @var TeamRepository
     */
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function handle(UpdateTeamCommand $command): void
    {
        $team = $this->teamRepository->findOneById($command->getId());
        $team->setName($command->getTeamName());

        $this->teamRepository->update($team);
    }
}
