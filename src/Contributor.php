<?php

namespace GitStaticAnalyzer;

use GitStaticAnalyzer\Helper\GitLog;

class Contributor
{
    private $name;

    private $commitCount;

    private $firstCommit;

    private $lastCommit;

    public function __construct($contributorString)
    {
        $contributorString = trim($contributorString);
        $chunks = explode("\t", $contributorString);
        $this->name = $chunks[1];
        $this->commitCount = $chunks[0];
        $this->firstCommit = GitLog::getCommitDate(false, $this->name);
        $this->lastCommit = GitLog::getCommitDate(true, $this->name);
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
