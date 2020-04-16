<?php

declare(strict_types=1);

namespace GitStaticAnalyzer;

class Utils
{
    public static function getVersion()
    {
        /*
         * cannot use constant here,
         * visibility must be declared on all constants if project supports PHP 7.1 or later,
         * visibility cannot be declared on constants in PHP 5
         */
        return '0.1.0';
    }

    public static function convertLogTimestampToDate($rawTimestamp)
    {
        $timestamp = (int) (trim($rawTimestamp));

        return date_create_from_format('U', $timestamp);
    }
}
