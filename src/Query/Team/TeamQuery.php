<?php

namespace App\Query\Team;

use App\View\TeamView;

interface TeamQuery
{
    public function getById(int $teamId): TeamView;
    public function getByTeamName(string $name): TeamView;
}
