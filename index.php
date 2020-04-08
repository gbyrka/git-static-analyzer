#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use GitStaticAnalyzer\Command\AnalyseCommand;
use Symfony\Component\Console\Application;

$application = new Application('Git Static Analyzer');

$application->addCommands(array(
    new AnalyseCommand()
));

$application->run();
