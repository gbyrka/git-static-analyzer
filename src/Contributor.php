<?php

namespace GitStaticAnalyzer;

use GitStaticAnalyzer\Helper\GitLog;

class Contributor
{
    private $name;

    private $commitCount;

    private $firstCommit;

    private $lastCommit;

    public static function fromString($contributorString)
    {
        $contributorString = trim($contributorString);
        $chunks = explode("\t", $contributorString);

        $name = $chunks[1];
        $commitCount = $chunks[0];
        $firstCommit = GitLog::getCommitDate(false, $name);
        $lastCommit = GitLog::getCommitDate(true, $name);

        return new static($name, $commitCount, $firstCommit, $lastCommit);
    }

    /**
     * @param string $name
     * @param int $commitCount
     * @param \DateTime $firstCommit
     * @param \DateTime $lastCommit
     */
    public function __construct($name, $commitCount, $firstCommit, $lastCommit)
    {
        $this->name = $name;
        $this->commitCount = $commitCount;
        $this->firstCommit = $firstCommit;
        $this->lastCommit = $lastCommit;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCommitCount()
    {
        return $this->commitCount;
    }

    public function getFirstCommit()
    {
        return $this->firstCommit;
    }

    public function getLastCommit()
    {
        return $this->lastCommit;
    }
}
