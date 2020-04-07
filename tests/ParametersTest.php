<?php

namespace Tests;

use GitStaticAnalyzer\Parameters;
use PHPUnit\Framework\TestCase;

final class ParametersTest extends TestCase
{
    public function testDefaultValues()
    {
        $p = new Parameters(2, array('abc', 'path'));

        $this->assertEquals('path', $p->getPath());
        $this->assertEquals('', $p->getProjectName());
        $this->assertEquals('report.html', $p->getFileName());
        $this->assertEquals(20, $p->getFilesCount());
        $this->assertEquals(50, $p->getContributorsCount());
    }

    public function testParametersSet()
    {
        $p = new Parameters(
            6,
            array(
                'abc',
                '../a/b/c',
                '--projectName=name',
                '--fileName=f1',
                '--filesCount=10',
                '--contributorsCount=15'
            )
        );

        $this->assertEquals('../a/b/c', $p->getPath());
        $this->assertEquals('name', $p->getProjectName());
        $this->assertEquals('f1.html', $p->getFileName());
        $this->assertEquals(10, $p->getFilesCount());
        $this->assertEquals(15, $p->getContributorsCount());
    }

    public function testUnknownParameter()
    {
        $this->setExpectedException('Exception', 'Unknown parameter: unknown');
        new Parameters(3, array('abc', 'path', '--unknown=123'));
    }

    public function testIncorrectParameterStart()
    {
        $this->setExpectedException('Exception', 'Incorrect parameter: -parameter=1');
        new Parameters(3, array('abc', 'path', '-parameter=1'));
        new Parameters(3, array('abc', 'path', '--para_meter=2'));
    }

    public function testIncorrectParameterNameFormat()
    {
        $this->setExpectedException('Exception', 'Incorrect parameter: --para_meter=2');
        new Parameters(3, array('abc', 'path', '--para_meter=2'));
    }

    public function testNoPathException()
    {
        $this->setExpectedException('Exception', 'Path is required');
        new Parameters(1, array('abc'));
    }
}
