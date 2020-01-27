<?php

namespace App\View;

use App\Entity\Team;
use DateTime;
use JMS\Serializer\Annotation\Type;

final class EventTeamView
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var DateTime
     *
     * @Type("DateTime")
     */
    private $date;

    public function __construct(EventView $eventView, Team $hostTeam, Team $guestTeam)
    {
        $this->id = $eventView->getId();
        $this->date = $eventView->getDate();
        $this->hostTeam = $hostTeam;
        $this->guestTeam = $guestTeam;
    }
}
