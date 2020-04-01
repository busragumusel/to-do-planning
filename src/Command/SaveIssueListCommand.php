<?php

namespace App\Command;

use App\Adapters\ProviderOneAdapter;
use App\Adapters\ProviderTwoAdapter;
use App\Strategy\IssueList;
use App\Entity\Issue;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SaveIssueListCommand extends Command
{
    protected static $defaultName = 'app:save-issue-list';

    private $entityManager;
    const PROVIDER_LIST = [
        ProviderOneAdapter::class,
        ProviderTwoAdapter::class
    ];

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->entityManager = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $list = [];
        foreach (self::PROVIDER_LIST as $provider) {
            $list = array_merge($list, (new IssueList(new $provider))->getAll());
        }

        $count = 1;
        $batchSize = 20;
        foreach ($list as $issue) {
            $issueRaw = new Issue();
            $issueRaw->setName($issue['name']);
            $issueRaw->setTiming($issue['timing']);
            $issueRaw->setDifficulty($issue['difficulty']);
            $this->entityManager->persist($issueRaw);
            if (($count % $batchSize) === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
            $count++;
        }
        $this->entityManager->flush();
        $this->entityManager->clear();

        return 0;
    }
}
