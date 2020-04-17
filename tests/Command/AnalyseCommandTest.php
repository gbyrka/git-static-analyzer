<?php

namespace GitStaticAnalyzer\Tests\Command;

use GitStaticAnalyzer\Command\AnalyseCommand;
use GitStaticAnalyzer\Contributor;
use GitStaticAnalyzer\File;
use GitStaticAnalyzer\Report\ReportParser;
use GitStaticAnalyzer\Repository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class AnalyseCommandTest extends TestCase
{
    /**
     * @var MockObject|ReportParser
     */
    private $reportParserMock;

    /**
     * @var MockObject|Repository
     */
    private $repositoryMock;

    protected function setUp()
    {
        parent::setUp();

        $this->reportParserMock = $this->createMock(ReportParser::class);
        $this->repositoryMock = $this->createMock(Repository::class);
    }

    protected function tearDown()
    {
        parent::tearDown();

        unlink('test-report.html');
    }

    /**
     * This scenario should test the whole execution of command, but the focus
     * is on parameters that user provides to the command.
     *
     * Other parts should be moved outside this command.
     */
    public function testExecute()
    {
        $filesCount = 3;
        $contributorsCount = 5;
        $fileName = 'test-report';
        $projectName = 'Test';

        $files = [
            new File('index.php', 3),
            new File('README.md', 2)
        ];

        $contributors = [
            new Contributor(
                'Joshua Carpenter',
                3,
                new \DateTimeImmutable('2020-04-01T12:00:00Z'),
                new \DateTimeImmutable('2020-04-08T12:00:00Z')
            ),
            new Contributor(
                'Robert Gonzalez',
                2,
                new \DateTimeImmutable('2020-04-06T12:00:00Z'),
                new \DateTimeImmutable('2020-04-14T13:14:00Z')
            ),
        ];

        $this->repositoryMock->expects(static::once())->method('getFirstCommitDate')->willReturn(
            new \DateTimeImmutable('2020-04-01T12:00:00Z')
        );

        $this->repositoryMock->expects(static::once())->method('getLastCommitDate')->willReturn(
            new \DateTimeImmutable('2020-04-14T13:14:00Z')
        );

        $this->repositoryMock
            ->expects(static::once())
            ->method('getTopContributors')
            ->with($contributorsCount)
            ->willReturn($contributors);

        $this->repositoryMock
            ->expects(static::once())
            ->method('getPopularFiles')
            ->with($filesCount)
            ->willReturn($files);

        $this->reportParserMock->expects(static::once())->method('parse')->willReturn('<p>Test template</p>');

        $command = new AnalyseCommand($this->reportParserMock, $this->repositoryMock);
        $tester = new CommandTester($command);

        $tester->execute([
            'path' => './', // current directory
            '--filename' => $fileName,
            '--contributors-count' => $contributorsCount,
            '--files-count' => $filesCount,
            '--project-name' => $projectName
        ]);

        static::assertFileExists($fileName . '.html');
    }
}
