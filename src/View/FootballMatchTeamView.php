<?php

namespace App\View;

use App\Entity\Team;
use DateTime;
use JMS\Serializer\Annotation\Type;

final class FootballMatchTeamView
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

    /**
     * @var Team
     */
    private $hostTeam;

    /**
     * @var Team
     */
    private $guestTeam;

    public function __construct(FootballMatchView $footballMatchView, Team $hostTeam, Team $guestTeam)
    {
        $this->id = $footballMatchView->getId();
        $this->date = $footballMatchView->getDate();
        $this->hostTeam = $hostTeam;
        $this->guestTeam = $guestTeam;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @return Team
     */
    public function getHostTeam(): Team
    {
        return $this->hostTeam;
    }

    /**
     * @return Team
     */
    public function getGuestTeam(): Team
    {
        return $this->guestTeam;
    }
}
