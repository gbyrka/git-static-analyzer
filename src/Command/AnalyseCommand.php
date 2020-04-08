<?php

namespace GitStaticAnalyzer\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AnalyseCommand extends Command
{
    protected static $defaultName = 'analyse';

    protected function configure()
    {
        $this
            ->setDescription('Analyse the project')
            ->addArgument('path', InputArgument::REQUIRED, 'path to the root of repository');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // This implementation is a temporary bridge to show how it would look
        // if we decide to use a Symfony Console component
        $argc = count($input->getArguments());
        $argv = array_values($input->getArguments());

        include_once dirname(dirname(dirname(__FILE__))) . '/analyse.php';

        return 1;
    }
}
