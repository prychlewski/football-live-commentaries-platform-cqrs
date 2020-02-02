<?php

namespace App\Handler\FootballMatch;

use App\Command\FootballMatch\UpdateFootballMatchCommand;
use App\Entity\Team;
use App\Repository\FootballMatchRepository;
use Doctrine\ORM\EntityManagerInterface;

class UpdateFootballMatchHandler
{
    /**
     * @var FootballMatchRepository
     */
    private $footballMatchRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        FootballMatchRepository $footballMatchRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->footballMatchRepository = $footballMatchRepository;
        $this->entityManager = $entityManager;
    }

    public function handle(UpdateFootballMatchCommand $command): void
    {
        $footballMatch = $this->footballMatchRepository->findOneById($command->getId());

        $fieldUpdateMap = [
            'hostTeam'  => $this->entityManager->getReference(Team::class, $command->getHostTeamId()),
            'guestTeam' => $this->entityManager->getReference(Team::class, $command->getGuestTeamId()),
            'date'      => $command->getDate(),
        ];

        foreach ($fieldUpdateMap as $property => &$newValue) {
            $currentSetter = 'set' . ucwords($property);
            if (!method_exists($footballMatch, $currentSetter)) {
                continue;
            }

            $valueGetter = 'get' . ucwords($property);
            if (!$this->shouldUpdateProperty($footballMatch->$valueGetter(), $newValue)) {
                continue;
            }
            $footballMatch->$currentSetter($newValue);
        }
        unset($newValue);

        $this->footballMatchRepository->update($footballMatch);
    }

    private function shouldUpdateProperty($currentValue, $newValue): bool
    {
        switch (true) {
            case $currentValue instanceof Team:
                return $currentValue->getId() !== $newValue->getId();
            case $currentValue instanceof \DateTime:
                return $currentValue !== $newValue;
            default:
                return false;
        }
    }
}
