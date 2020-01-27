<?php

namespace App\Command\Event;

use App\Model\Request\EventRequestModel;
use DateTime;

abstract class AbstractBaseEventCommand
{
    /**
     * @var int
     */
    protected $hostTeamId;

    /**
     * @var int
     */
    protected $guestTeamId;

    /**
     * @var DateTime
     */
    protected $date;

    public function __construct(EventRequestModel $eventRequestModel)
    {
        $this->hostTeamId = $eventRequestModel->getHostTeamId();
        $this->guestTeamId = $eventRequestModel->getGuestTeamId();
        $this->date = $eventRequestModel->getDate();
    }

    /**
     * @return int
     */
    public function getHostTeamId(): int
    {
        return $this->hostTeamId;
    }

    /**
     * @return int
     */
    public function getGuestTeamId(): int
    {
        return $this->guestTeamId;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }
}
