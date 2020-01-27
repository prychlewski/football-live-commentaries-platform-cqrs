<?php

namespace App\Handler\Event;

use App\Command\Event\DeleteEventCommand;
use App\Exception\EventNotFoundException;
use App\Repository\EventRepository;

class DeleteEventHandler
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function handle(DeleteEventCommand $command): void
    {
        $event = $this->eventRepository->findOneById($command->getId());
        if (!$event) {
            throw new EventNotFoundException();
        }

        $this->eventRepository->delete($event);
    }
}
