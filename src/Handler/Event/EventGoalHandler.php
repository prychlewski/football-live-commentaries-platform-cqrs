<?php

namespace App\Handler\Event;

use App\Command\Event\CreateEventCommand;
use App\Command\Event\EventGoalCommand;
use App\Entity\Event;
use App\Entity\Team;
use App\Exception\TeamDoesNotTakePartInEventException;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;

class EventGoalHandler
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function handle(EventGoalCommand $command): void
    {
        $event = $this->eventRepository->findOneById($command->getEventId());
        $teamId = $command->getTeamId();

        $providedTeam = null;
        switch (true) {
            case $event->getGuestTeam()->getId() === $teamId:
                $providedTeam = 'guest';
                break;
            case $event->getHostTeam()->getId() === $teamId:
                $providedTeam = 'host';
                break;
            default:
                throw new TeamDoesNotTakePartInEventException();
        }

        $pointsSetter = sprintf('set%sPoints', ucwords($providedTeam));
        $pointsGetter = sprintf('get%sPoints', ucwords($providedTeam));
        if (!method_exists($event, $pointsSetter)) {
            throw new \BadMethodCallException('there is no method named: ' . $pointsSetter);
        }

        $score = $event->$pointsGetter();
        $event->$pointsSetter(++$score);

        $this->eventRepository->update($event);
    }
}
