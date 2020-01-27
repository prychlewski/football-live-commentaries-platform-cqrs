<?php

namespace App\Query\Event;

use App\Model\Request\EventRequestModel;
use App\View\EventView;
use DateTime;

interface EventQuery
{
    public function getById(int $eventId): EventView;
    public function getByTeamsIdsAndDate(int $hostTeamId, int $guestTeamId, DateTime $date): EventView;
    public function getByRequestModel(EventRequestModel $eventRequestModel): EventView;
}
