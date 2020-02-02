<?php

namespace App\Command\FootballMatch;

use App\Model\Request\FootballMatchRequestModel;

class UpdateFootballMatchCommand extends AbstractBaseFootballMatchCommand
{
    /**
     * @var int
     */
    private $id;

    public function __construct(int $id, FootballMatchRequestModel $footballMatchRequestModel)
    {
        $this->id = $id;

        parent::__construct($footballMatchRequestModel);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
