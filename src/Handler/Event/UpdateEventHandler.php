<?php

namespace App\Handler\Event;

use App\Command\Event\UpdateEventCommand;
use App\Entity\Team;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;

class UpdateEventHandler
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EventRepository $eventRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->eventRepository = $eventRepository;
        $this->entityManager = $entityManager;
    }

    public function handle(UpdateEventCommand $command): void
    {
        $event = $this->eventRepository->findOneById($command->getId());

        $fieldUpdateMap = [
            'hostTeam'  => $this->entityManager->getReference(Team::class, $command->getHostTeamId()),
            'guestTeam' => $this->entityManager->getReference(Team::class, $command->getGuestTeamId()),
            'date'      => $command->getDate(),
        ];

        foreach ($fieldUpdateMap as $property => &$newValue) {
            $currentSetter = 'set' . ucwords($property);
            if (!method_exists($event, $currentSetter)) {
                continue;
            }

            $valueGetter = 'get' . ucwords($property);
            if (!$this->shouldUpdateProperty($event->$valueGetter(), $newValue)) {
                continue;
            }
            $event->$currentSetter($newValue);
        }
        unset($newValue);

        $this->eventRepository->update($event);
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
