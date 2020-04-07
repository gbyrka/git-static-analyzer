<?php

namespace GitStaticAnalyzer;

class File
{
    private $name = '';

    private $commitCount;

    public function __construct($contributorString)
    {
        $contributorString = trim($contributorString);
        $chunks = explode(' ', $contributorString);

        if (isset($chunks[1])) {
            $this->name = $chunks[1];
        }

        $this->commitCount = $chunks[0];
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
