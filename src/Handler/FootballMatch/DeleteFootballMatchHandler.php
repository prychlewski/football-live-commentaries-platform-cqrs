<?php

namespace App\Handler\FootballMatch;

use App\Command\FootballMatch\DeleteFootballMatchCommand;
use App\Exception\FootballMatchNotFoundException;
use App\Repository\FootballMatchRepository;

class DeleteFootballMatchHandler
{
    /**
     * @var FootballMatchRepository
     */
    private $footballMatchRepository;

    public function __construct(FootballMatchRepository $footballMatchRepository)
    {
        $this->footballMatchRepository = $footballMatchRepository;
    }

    public function handle(DeleteFootballMatchCommand $command): void
    {
        $footballMatch = $this->footballMatchRepository->findOneById($command->getId());
        if (!$footballMatch) {
            throw new FootballMatchNotFoundException();
        }

        $this->footballMatchRepository->delete($footballMatch);
    }
}
