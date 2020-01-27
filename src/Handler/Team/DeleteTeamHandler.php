<?php

namespace App\Handler\Team;

use App\Command\Team\DeleteTeamCommand;
use App\Exception\TeamNotFoundException;
use App\Repository\TeamRepository;

class DeleteTeamHandler
{
    /**
     * @var TeamRepository
     */
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function handle(DeleteTeamCommand $command): void
    {
        $team = $this->teamRepository->findOneById($command->getId());
        if (!$team) {
            throw new TeamNotFoundException();
        }

        $this->teamRepository->delete($team);
    }
}
