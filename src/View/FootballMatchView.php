<?php

namespace App\View;

use DateTime;
use JMS\Serializer\Annotation\Type;

final class FootballMatchView
{
    /**
     * @var int
     *
     * @Type("integer")
     */
    private $id;

    /**
     * @var DateTime
     *
     * @Type("DateTime")
     */
    private $date;

    /**
     * @var int
     *
     * @Type("integer")
     */
    private $hostTeamId;

    /**
     * @var int
     *
     * @Type("integer")
     */
    private $guestTeamId;

    /**
     * @var int
     *
     * @Type("integer")
     */
    private $hostPoints;

    /**
     * @var int
     *
     * @Type("integer")
     */
    private $guestPoints;

    public function __construct(array $footballMatch)
    {
        $this->id = $footballMatch['id'];
        $this->hostTeamId = $footballMatch['host_team_id'];
        $this->guestTeamId = $footballMatch['guest_team_id'];
        $this->date = new DateTime($footballMatch['date']);
        $this->hostPoints = $footballMatch['host_points'];
        $this->guestPoints = $footballMatch['guest_points'];
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getHostPoints(): int
    {
        return $this->hostPoints;
    }

    /**
     * @return int
     */
    public function getGuestPoints(): int
    {
        return $this->guestPoints;
    }
}
