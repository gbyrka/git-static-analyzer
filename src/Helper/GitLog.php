<?php

namespace GitStaticAnalyzer\Helper;

use GitStaticAnalyzer\Contributor;
use GitStaticAnalyzer\File;

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

    public static function getTopContributors($maxResults = 50)
    {
        $response = shell_exec('git shortlog -sn --no-merges | head -n ' . $maxResults);

        $lines = array_filter(explode(PHP_EOL, $response));

        return array_map([Contributor::class, 'fromString'], $lines);
    }

    public static function getPopularFileLines($maxFiles = 20)
    {
        $gitLogResponse = shell_exec('git log --name-only --pretty=format: | sort | uniq -c | sort -nr');

        $lines = explode(PHP_EOL, $gitLogResponse);
        $accumulatedFiles = [];

        while ($lines && $accumulatedFiles < $maxFiles) {
            $file = File::fromString(array_shift($lines));

            if (!$file->getName()) {
                continue;
            }

            $accumulatedFiles[] = $file;
        }

        return $accumulatedFiles;
    }
}
