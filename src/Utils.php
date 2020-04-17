<?php

declare(strict_types=1);

namespace GitStaticAnalyzer;

use DateTimeImmutable;

class Utils
{
    /**
     * Get version number of the tool. It's set by box tool during bundling into the PHAR package.
     * @see https://github.com/humbug/box/blob/master/doc/configuration.md#git-tag-placeholder-git-tag
     *
     * @return string
     */
    public static function getVersion(): string
    {
        return '@git_tag@';
    }

    public static function convertLogTimestampToDate($rawTimestamp): DateTimeImmutable
    {
        $timestamp = (int) (trim($rawTimestamp));

        return date_create_immutable_from_format('U', (string) $timestamp);
    }
}
