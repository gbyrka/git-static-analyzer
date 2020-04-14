<?php

namespace GitStaticAnalyzer\Command;

use GitStaticAnalyzer\Contributor;
use GitStaticAnalyzer\File;
use GitStaticAnalyzer\Helper\GitLog;
use GitStaticAnalyzer\Helper\Utils;
use GitStaticAnalyzer\Report\HtmlReportGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AnalyseCommand extends Command
{
    protected static $defaultName = 'analyse';

    private $reportGenerator;

    public function __construct(HtmlReportGenerator $reportGenerator)
    {
        parent::__construct();
        $this->reportGenerator = $reportGenerator;
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

        $firstCommit = GitLog::getCommitDate(false);
        $lastCommit = GitLog::getCommitDate(true);
        $leftBoundry = $firstCommit->getTimestamp();

        $contributors = GitLog::getTopContributors($input->getOption('contributors-count'));
        $popularFiles = GitLog::getPopularFileLines();

        $report = $this->reportGenerator->parse('template.php', [
            'projectName' => $input->getOption('project-name'),
            'currentDate' => date('Y-m-d H:i'),
            'firstCommit' => $firstCommit->format('Y-m-d'),
            'lastCommit' => $lastCommit->format('Y-m-d'),
            'contributors' => $contributors,
            'leftBoundry' => $leftBoundry,
            'width' => 100,
            'size' => $lastCommit->getTimestamp() - $leftBoundry,
            'popularFiles' => $popularFiles,
            'version' => Utils::getVersion()
        ]);

        fwrite($file, $report);
        fclose($file);

        return 1;
    }
}
