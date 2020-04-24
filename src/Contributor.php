<?php

declare(strict_types=1);

namespace GitStaticAnalyzer;

use DateTimeImmutable;

class Contributor
{
    private $name;
    private $commitCount;
    private $firstCommit;
    private $lastCommit;

    public function __construct(
        string $name,
        int $commitCount,
        DateTimeImmutable $firstCommit,
        DateTimeImmutable $lastCommit
    ) {
        $this->name = $name;
        $this->commitCount = $commitCount;
        $this->firstCommit = $firstCommit;
        $this->lastCommit = $lastCommit;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCommitCount(): int
    {
        return $this->commitCount;
    }

    public function getFirstCommit(): DateTimeImmutable
    {
        return $this->firstCommit;
    }

    public function getLastCommit(): DateTimeImmutable
    {
        return $this->lastCommit;
    }
}
