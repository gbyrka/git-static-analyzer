<?php

declare(strict_types=1);

namespace GitStaticAnalyzer;

class Contributor
{
    private $name;

    private $commitCount;

    private $firstCommit;

    private $lastCommit;

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
