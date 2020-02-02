<?php

namespace App\Query\FootballMatch;

use App\Model\Request\FootballMatchRequestModel;
use App\View\FootballMatchView;
use DateTime;

interface FootballMatchQuery
{
    public function getById(int $footballMatchId): FootballMatchView;
    public function getByTeamsIdsAndDate(int $hostTeamId, int $guestTeamId, DateTime $date): FootballMatchView;
    public function getByRequestModel(FootballMatchRequestModel $footballMatchRequestModel): FootballMatchView;
}
