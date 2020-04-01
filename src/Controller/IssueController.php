<?php

namespace App\Controller;

use App\Repository\DeveloperRepository;
use App\Repository\IssueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IssueController extends AbstractController
{
    private $developerRepository;
    private $issueRepository;

    const WEEKLY_WORKING_HOURS = 45;

    public function __construct(DeveloperRepository $developerRepository, IssueRepository $issueRepository)
    {
        $this->developerRepository = $developerRepository;
        $this->issueRepository = $issueRepository;
    }

    /**
     * @Route("/", name="plan")
     *
     * @return Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function plan()
    {
        $toDoList = [];
        $developerList = $this->developerRepository->all();
        $issueList = $this->issueRepository->all();

        $averageTimeDuration = round($this->issueRepository->sumTimingByDifficulty()
            / (self::WEEKLY_WORKING_HOURS * count($developerList))
        );

        for ($week=1; $week<=$averageTimeDuration; $week++) {
            foreach ($developerList as $developer) {
                $hours = 0;
                foreach ($issueList as $key => $issue) {
                    if (
                        $hours + $issue->getTiming() <= self::WEEKLY_WORKING_HOURS
                        && $issue->getDifficulty() <= $developer->getCapacityPerHour()
                    ) {
                        $toDoList[$week][$developer->getName()][] = $issue->getName();
                        unset($issueList[$key]);
                        $hours += $issue->getTiming();
                    }
                }
            }

            if (empty($issueList)) {
                break;
            }
        }

        return $this->render('/homepage.html', [
            'duration' => $averageTimeDuration,
            'toDoList' => $toDoList
        ]);
    }
}
