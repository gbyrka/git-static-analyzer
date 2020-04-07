<?php

namespace GitStaticAnalyzer\Helper;

class GitLog
{
    public static function getCommitDate($lastCommit = false, $author = '')
    {
        $reverseString = $lastCommit ? '' : ' --reverse';

        $authorString = ($author === '') ? '' : ' --author="' . $author . '"';

        $commitResponse = shell_exec(
            'git log --pretty=format:"%ad%" --date=raw' . $authorString . $reverseString . ' | head -n 1'
        );

        return Utils::convertLogTimestampToDate($commitResponse);
    }

    public static function getTopContributors($count)
    {
        return shell_exec('git shortlog -sn --no-merges | head -n ' . $count);
    }

    public static function getPopularFileLines()
    {
        $gitLogResponse = shell_exec('git log --name-only --pretty=format: | sort | uniq -c | sort -nr');

        return explode(PHP_EOL, $gitLogResponse);
    }
}
