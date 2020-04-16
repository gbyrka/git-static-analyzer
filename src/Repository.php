<?php

declare(strict_types=1);

namespace GitStaticAnalyzer;

use GitStaticAnalyzer\DataProvider\GitDataProvider;

class Repository
{
    private $dataProvider;

    public function __construct(GitDataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    public function getFirstCommitDate(string $author = ''): \DateTime
    {
        return Utils::convertLogTimestampToDate(
            $this->dataProvider->getFirstCommitDate($author)
        );
    }

    public function getLastCommitDate(string $author = ''): \DateTime
    {
        return Utils::convertLogTimestampToDate(
            $this->dataProvider->getLastCommitDate($author)
        );
    }

    public function getTopContributors($maxResults = 50): array
    {
        $response = $this->dataProvider->getTopContributors($maxResults);

        $lines = array_filter(explode(PHP_EOL, $response));

        return array_map(function (string $contributorString) {
            $contributorString = trim($contributorString);
            $chunks = explode("\t", $contributorString);

            $name = $chunks[1];
            $commitCount = $chunks[0];
            $firstCommit = $this->getFirstCommitDate($name);
            $lastCommit = $this->getLastCommitDate($name);

            return new Contributor($name, $commitCount, $firstCommit, $lastCommit);
        }, $lines);
    }

    public function getPopularFiles(int $maxFiles = 20): array
    {
        $response = $this->dataProvider->getPopularFiles();

        $lines = explode(PHP_EOL, $response);
        $accumulatedFiles = [];

        while ($lines && count($accumulatedFiles) < $maxFiles) {
            $file = File::fromString(array_shift($lines));

            if (!$file->getName()) {
                continue;
            }

            $accumulatedFiles[] = $file;
        }

        return $accumulatedFiles;
    }
}
