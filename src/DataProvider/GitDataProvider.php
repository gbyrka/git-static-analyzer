<?php

declare(strict_types=1);

namespace GitStaticAnalyzer\DataProvider;

/**
 * This class is intended to compose a query (or shell command) to retrieve necessary data
 * from the git repository. No data transformations are performed at this stage.
 */
class GitDataProvider
{
    /**
     * Return the timestamp of the first commit in the repository or for the given author.
     *
     * @param string $author
     * @return string
     */
    public function getFirstCommitDate(string $author = ''): string
    {
        return $this->getCommitDate(false, $author);
    }

    /**
     * Return the timestamp of the last commit in the repository or for the given author.
     *
     * @param string $author
     * @return string
     */
    public function getLastCommitDate(string $author = ''): string
    {
        return $this->getCommitDate(true, $author);
    }

    /**
     * Return the contributors list ordered by the descending number of commits.
     *
     * @param int $maxResults
     * @return string
     */
    public function getTopContributors(int $maxResults): string
    {
        return shell_exec('git shortlog -sn --no-merges | head -n ' . $maxResults);
    }

    /**
     * Return the list of files ordered by the descending number of commits they appeared in.
     *
     * @return string
     */
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
