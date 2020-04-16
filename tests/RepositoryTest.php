<?php

namespace GitStaticAnalyzer\Tests;

use DateTime;
use GitStaticAnalyzer\Contributor;
use GitStaticAnalyzer\DataProvider\GitDataProvider;
use GitStaticAnalyzer\File;
use GitStaticAnalyzer\Repository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var MockObject|GitDataProvider
     */
    private $dataProvider;

    protected function setUp()
    {
        parent::setUp();

        $this->dataProvider = $this->getMockBuilder(GitDataProvider::class)->getMock();
        $this->repository = new Repository($this->dataProvider);
    }

    public function testGetFirstCommitDate()
    {
        $this->dataProvider->method('getFirstCommitDate')->willReturn(static::getResponse('get-first-commit-date.txt'));

        $date = $this->repository->getFirstCommitDate();

        static::assertEquals($date, new DateTime('2020-04-07T15:28:01+0200'));
    }

    public function testGetLastCommitDate()
    {
        $this->dataProvider->method('getLastCommitDate')->willReturn(static::getResponse('get-last-commit-date.txt'));

        $date = $this->repository->getLastCommitDate();

        static::assertEquals($date, new DateTime('2020-04-14T12:11:34+0200'));
    }

    public function testGetTopContributors()
    {
        $this->dataProvider->method('getTopContributors')->willReturn(static::getResponse('get-top-contributors.txt'));

        $contributors = $this->repository->getTopContributors(10); // fixed number that depends on the git response

        static::assertCount(10, $contributors);
        static::assertContainsOnlyInstancesOf(Contributor::class, $contributors);
    }

    public function testGetPopularFiles()
    {
        $this->dataProvider->method('getPopularFiles')->willReturn(static::getResponse('get-popular-files.txt'));

        $files = $this->repository->getPopularFiles(10);

        static::assertCount(10, $files);
        static::assertContainsOnlyInstancesOf(File::class, $files);
    }

    protected static function getResponse(string $fileName): string
    {
        return file_get_contents(__DIR__ . '/_support/git-log-responses/' . $fileName);
    }
}
