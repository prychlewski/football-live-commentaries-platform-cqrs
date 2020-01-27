<?php

namespace App\Command\Event;

class UpdateEventCommand extends AbstractBaseEventCommand
{
    /**
     * @var int
     */
    private $id;

    public function __construct(int $id, $eventRequestModel)
    {
        $this->id = $id;

        parent::__construct($eventRequestModel);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
