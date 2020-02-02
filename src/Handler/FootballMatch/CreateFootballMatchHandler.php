<?php

namespace App\Handler\FootballMatch;

use App\Command\FootballMatch\CreateFootballMatchCommand;
use App\Entity\FootballMatch;
use App\Entity\Team;
use App\Repository\FootballMatchRepository;
use Doctrine\ORM\EntityManagerInterface;

class CreateFootballMatchHandler
{
    /**
     * @var FootballMatchRepository
     */
    private $footballMatchRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(FootballMatchRepository $footballMatchRepository, EntityManagerInterface $entityManager)
    {
        $this->footballMatchRepository = $footballMatchRepository;
        $this->entityManager = $entityManager;
    }

    public function handle(CreateFootballMatchCommand $command): void
    {
        $hostTeam = $this->entityManager->getReference(Team::class, $command->getHostTeamId());
        $guestTeam = $this->entityManager->getReference(Team::class, $command->getGuestTeamId());

        $footballMatch = new FootballMatch(
            $hostTeam,
            $guestTeam,
            $command->getDate()
        );

        $this->footballMatchRepository->add($footballMatch);
    }
}
