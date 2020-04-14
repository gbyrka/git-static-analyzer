#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use GitStaticAnalyzer\Command\AnalyseCommand;
use Symfony\Component\Console\Application;

$application = new Application('Git Static Analyzer');

$reportGenerator = new \GitStaticAnalyzer\Report\HtmlReportGenerator(
    __DIR__ . DIRECTORY_SEPARATOR . 'templates'
);

$application->addCommands(array(
    new AnalyseCommand($reportGenerator)
));

$application->run();
