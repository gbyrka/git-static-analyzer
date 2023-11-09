<?php

declare(strict_types=1);

namespace GitStaticAnalyzer\Report;

class ReportParser
{
    private string $templateDirectory;
    public function __construct(string $templateDirectory)
    {
        $this->templateDirectory = trim($templateDirectory);
    }

    public function parse(string $view, array $data = []): string
    {
        extract($data);
        ob_start();
        include_once($this->templateDirectory . DIRECTORY_SEPARATOR . $view);

        return ob_get_clean();
    }
}
