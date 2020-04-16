#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use GitStaticAnalyzer\Command\AnalyseCommand;
use GitStaticAnalyzer\DataProvider\GitDataProvider;
use GitStaticAnalyzer\Report\ReportParser;
use GitStaticAnalyzer\Repository;
use Symfony\Component\Console\Application;

$application = new Application('Git Static Analyzer');

$reportGenerator = new ReportParser(
    __DIR__ . DIRECTORY_SEPARATOR . 'templates'
);

$repository = new Repository(
    new GitDataProvider()
);

$application->addCommands(array(
    new AnalyseCommand($reportGenerator, $repository)
));

$application->run();
