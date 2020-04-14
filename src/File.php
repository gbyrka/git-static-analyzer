<?php

namespace GitStaticAnalyzer;

class File
{
    private $name = '';
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

        if (isset($chunks[1])) {
            $name = trim($chunks[1]);
        }

        $commitCount = trim($chunks[0]);

        return new static($name, $commitCount);
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
