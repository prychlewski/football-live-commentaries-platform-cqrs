<?php

namespace App\Command\Team;

use App\Model\Request\TeamRequestModel;

class UpdateTeamCommand extends AbstractTeamCommand
{
    /**
     * @var int
     */
    private $id;

    public function __construct(int $id, TeamRequestModel $teamRequestModel)
    {
        $this->id = $id;

        parent::__construct($teamRequestModel);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
