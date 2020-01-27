<?php

namespace App\Handler\Event;

use App\Command\Event\CreateEventCommand;
use App\Entity\Event;
use App\Entity\Team;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;

class CreateEventHandler
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EventRepository $eventRepository, EntityManagerInterface $entityManager)
    {
        $this->eventRepository = $eventRepository;
        $this->entityManager = $entityManager;
    }

    public function handle(CreateEventCommand $command): void
    {
        $hostTeam = $this->entityManager->getReference(Team::class, $command->getHostTeamId());
        $guestTeam = $this->entityManager->getReference(Team::class, $command->getGuestTeamId());

        $team = new Event(
            $hostTeam,
            $guestTeam,
            $command->getDate()
        );

        $this->eventRepository->add($team);
    }
}
