<?php

namespace GitStaticAnalyzer;

class Parameters
{
    private $analyseFrom;

    private $analyseTo;

    private $contributorsCount = 50;

    private $fileName = 'report';

    private $filesCount = 20;

    private $path = '';

    private $projectName = '';

    public function __construct($argc, $argv)
    {
        if ($argc < 2) {
            throw new \Exception('Path is required');
        }

        $this->path = $argv[1];

        for ($a = 2; $a < $argc; $a++) {
            $this->handleParameter($argv[$a]);
        }
    }

    public function getAnalyseFrom()
    {
        return $this->analyseFrom;
    }

    public function getAnalyseTo()
    {
        return $this->analyseTo;
    }

    public function getFileName()
    {
        return $this->fileName . '.html';
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getProjectName()
    {
        return $this->projectName;
    }

    public function getContributorsCount()
    {
        return $this->contributorsCount;
    }

    public function getFilesCount()
    {
        return $this->filesCount;
    }

    private function handleParameter($parameter)
    {
        if (! preg_match('/--[a-zA-Z]+=[\d\.\/\-a-zA-Z]+/', $parameter)) {
            throw new \Exception('Incorrect parameter: ' . $parameter);
        };

        $dividerPosition = strpos($parameter, '=');
        $parameterName = substr($parameter, 2, $dividerPosition - 2);
        $parameterValue = substr($parameter, $dividerPosition + 1);

        switch ($parameterName) {
            case 'projectName':
                $this->projectName = $parameterValue;
                break;
            case 'fileName':
                $this->fileName = $parameterValue;
                break;
            case 'filesCount':
                $this->filesCount = (int) $parameterValue;
                break;
            case 'contributorsCount':
                $this->contributorsCount = (int) $parameterValue;
                break;
            default:
                throw new \Exception('Unknown parameter: ' . $parameterName);
        }
    }
}
