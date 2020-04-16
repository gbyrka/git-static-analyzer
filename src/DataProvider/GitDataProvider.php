<?php

declare(strict_types=1);

namespace GitStaticAnalyzer\DataProvider;

class GitDataProvider
{
    public function getFirstCommitDate(string $author = ''): string
    {
        return $this->getCommitDate(false, $author);
    }

    public function getLastCommitDate(string $author = ''): string
    {
        return $this->getCommitDate(true, $author);
    }

    public function getTopContributors(int $maxResults): string
    {
        return shell_exec('git shortlog -sn --no-merges | head -n ' . $maxResults);
    }

    public function getPopularFiles(): string
    {
        return shell_exec('git log --name-only --pretty=format: | sort | uniq -c | sort -nr');
    }

    private function getCommitDate(bool $lastCommit = false, string $author = '')
    {
        $reverseString = $lastCommit ? '' : ' --reverse';

        $authorString = ($author === '') ? '' : ' --author="' . $author . '"';

        return  shell_exec(
            'git log --pretty=format:"%ad%" --date=raw' . $authorString . $reverseString . ' | head -n 1'
        );
    }
}
