<?php

namespace App\Handler\FootballMatch;

use App\Command\FootballMatch\CreateFootballMatchCommand;
use App\Command\FootballMatch\GoalCommand;
use App\Entity\FootballMatch;
use App\Entity\Team;
use App\Exception\TeamDoesNotTakePartInMatchException;
use App\Repository\FootballMatchRepository;
use Doctrine\ORM\EntityManagerInterface;

class GoalHandler
{
    /**
     * @var FootballMatchRepository
     */
    private $footballMatchRepository;

    public function __construct(FootballMatchRepository $footballMatchRepository)
    {
        $this->footballMatchRepository = $footballMatchRepository;
    }

    public function handle(GoalCommand $command): void
    {
        $footballMatch = $this->footballMatchRepository->findOneById($command->getFootballMatchId());
        $teamId = $command->getTeamId();

        $providedTeam = null;
        switch (true) {
            case $footballMatch->getGuestTeam()->getId() === $teamId:
                $providedTeam = 'guest';
                break;
            case $footballMatch->getHostTeam()->getId() === $teamId:
                $providedTeam = 'host';
                break;
            default:
                throw new TeamDoesNotTakePartInMatchException();
        }

        $pointsSetter = sprintf('set%sPoints', ucwords($providedTeam));
        $pointsGetter = sprintf('get%sPoints', ucwords($providedTeam));
        if (!method_exists($footballMatch, $pointsSetter)) {
            throw new \BadMethodCallException('there is no method named: ' . $pointsSetter);
        }

        $score = $footballMatch->$pointsGetter();
        $footballMatch->$pointsSetter(++$score);

        $this->footballMatchRepository->update($footballMatch);
    }
}
