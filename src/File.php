<?php

declare(strict_types=1);

namespace GitStaticAnalyzer;

class File
{
    private $name;
    private $commitCount;

    public function __construct(string $name, int $commitCount)
    {
        $this->name = $name;
        $this->commitCount = $commitCount;
    }

    public static function fromString($fileString)
    {
        $fileString = trim($fileString);
        $chunks = explode(' ', $fileString);

        $name = isset($chunks[1]) ? trim($chunks[1]) : '';
        $commitCount = trim($chunks[0]);

        return new static($name, (int)$commitCount);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCommitCount()
    {
        return $this->commitCount;
    }
}
