<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;

use function Gendiff\Gen\genDiff;

class GenTest extends TestCase
{
    public function getFixtureFullPath($fixtureName)
    {
        $parts = [__DIR__, 'fixtures', $fixtureName];
        return realpath(implode('/', $parts));
    }

    public function testMain1(): void
    {
         
        $fileName1 = $this->getFixtureFullPath("file1.json");
        $fileName2 = $this->getFixtureFullPath("file2.json");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result12.txt"), genDiff($fileName1, $fileName2));
    }

    public function testMain2(): void
    {
        $fileName1 = $this->getFixtureFullPath("file1.json");
        $fileName2 = $this->getFixtureFullPath("blank.json");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result1blank.txt"), genDiff($fileName1, $fileName2));
    }
}
