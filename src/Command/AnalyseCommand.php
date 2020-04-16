<?php

declare(strict_types=1);

namespace GitStaticAnalyzer\Command;

use GitStaticAnalyzer\Repository;
use GitStaticAnalyzer\Utils;
use GitStaticAnalyzer\Report\ReportParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AnalyseCommand extends Command
{
    protected static $defaultName = 'analyse';

    private $reportGenerator;
    private $repository;

    public function __construct(ReportParser $reportGenerator, Repository $repository)
    {
        parent::__construct();
        $this->reportGenerator = $reportGenerator;
        $this->repository = $repository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Analyse the project')
            ->addArgument('path', InputArgument::REQUIRED, 'path to the root of repository')
            ->addOption('filename', 'f', InputOption::VALUE_OPTIONAL, '', 'report')
            ->addOption('project-name', 'p', InputOption::VALUE_OPTIONAL, '', null)
            ->addOption('files-count', null, InputOption::VALUE_OPTIONAL, '', 20)
            ->addOption('contributors-count', null, InputOption::VALUE_OPTIONAL, '', 50)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = fopen($input->getOption('filename') . '.html', 'w');

        chdir($input->getArgument('path'));

        $firstCommit = $this->repository->getFirstCommitDate();
        $lastCommit = $this->repository->getLastCommitDate();
        $leftBoundary = $firstCommit->getTimestamp();

        $contributors = $this->repository->getTopContributors((int)$input->getOption('contributors-count'));
        $popularFiles = $this->repository->getPopularFiles((int)$input->getOption('files-count'));

        $report = $this->reportGenerator->parse('template.php', [
            'projectName' => $input->getOption('project-name'),
            'currentDate' => date('Y-m-d H:i'),
            'firstCommit' => $firstCommit->format('Y-m-d'),
            'lastCommit' => $lastCommit->format('Y-m-d'),
            'contributors' => $contributors,
            'leftBoundary' => $leftBoundary,
            'width' => 100,
            'size' => $lastCommit->getTimestamp() - $leftBoundary,
            'popularFiles' => $popularFiles,
            'version' => Utils::getVersion()
        ]);

        fwrite($file, $report);
        fclose($file);

        return 1;
    }
}
