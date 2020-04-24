<?php

namespace GitStaticAnalyzer\Tests\Report;

use GitStaticAnalyzer\Report\ReportParser;
use PHPUnit\Framework\TestCase;

class ReportParserTest extends TestCase
{
    public function testParse()
    {
        $parser = new ReportParser(dirname(__DIR__) . '/_support/templates');

        $output = $parser->parse('test.php', ['text' => 'Example Text']);

        static::assertContains('<p>Example Text</p>', $output);
    }
}
