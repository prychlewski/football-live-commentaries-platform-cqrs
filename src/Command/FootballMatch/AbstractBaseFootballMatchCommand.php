<?php

namespace App\Command\FootballMatch;

use App\Model\Request\FootballMatchRequestModel;
use DateTime;

abstract class AbstractBaseFootballMatchCommand
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

    public function __construct(FootballMatchRequestModel $footballMatchRequestModel)
    {
        $this->hostTeamId = $footballMatchRequestModel->getHostTeamId();
        $this->guestTeamId = $footballMatchRequestModel->getGuestTeamId();
        $this->date = $footballMatchRequestModel->getDate();
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
