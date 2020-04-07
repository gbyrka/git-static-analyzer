<?php

use GitStaticAnalyzer\Contributor;
use GitStaticAnalyzer\Helper\GitLog;
use GitStaticAnalyzer\Helper\Utils;
use GitStaticAnalyzer\Parameters;
use GitStaticAnalyzer\File;

require __DIR__ . '/vendor/autoload.php';

try {
    $parameters = new Parameters($argc, $argv);
} catch (\Exception $e) {
    echo $e->getMessage() . "\n";
    exit();
}

$file = fopen($parameters->getFileName(), 'w');

chdir($parameters->getPath());

//first and last commit date
$firstCommit = GitLog::getCommitDate(false);
$lastCommit = GitLog::getCommitDate(true);

$leftBoundry = $firstCommit->getTimestamp();
$size = $lastCommit->getTimestamp() - $leftBoundry;
$width = 1000; //width of engagement pictures

//get contributors
$contributorResponse = GitLog::getTopContributors($parameters->getContributorsCount());
$lines = explode(PHP_EOL, $contributorResponse);
$contributors = [];
foreach ($lines as $line) {
    if (strlen($line) === 0) { //to skip empty lines
        continue;
    }

    $contributors[] = new Contributor($line);
}

//Files edited most often
$lines = GitLog::getPopularFileLines();
$popularFiles = [];
$count = 0;
foreach ($lines as $line) {
    if ($count++ > $parameters->getFilesCount()) {
        break;
    }

    $popularFile = new File($line);

    if (strlen($popularFile->getName()) === 0) { //to skip empty line
        continue;
    }

    $popularFiles[] = $popularFile;
}

$version = Utils::getVersion();

ob_start();
include_once('src/template.php');
$htmlStr = ob_get_clean();
fwrite($file, $htmlStr);
fclose($file);
