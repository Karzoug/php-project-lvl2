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

    public function testPlainJSON1(): void
    {
         
        $fileName1 = $this->getFixtureFullPath("file1.json");
        $fileName2 = $this->getFixtureFullPath("file2.JSON");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result12.txt"), genDiff($fileName1, $fileName2));
    }

    public function testPlainJSON2(): void
    {
        $fileName1 = $this->getFixtureFullPath("file1.json");
        $fileName2 = $this->getFixtureFullPath("blank.json");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result1blank.txt"), genDiff($fileName1, $fileName2));
    }

    public function testPlainYAML1(): void
    {
        $fileName1 = $this->getFixtureFullPath("file1.yml");
        $fileName2 = $this->getFixtureFullPath("file2.YAML");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result12.txt"), genDiff($fileName1, $fileName2));
    }

    public function testPlainYAML2(): void
    {
        $fileName1 = $this->getFixtureFullPath("file1.yml");
        $fileName2 = $this->getFixtureFullPath("blank.yaml");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result1blank.txt"), genDiff($fileName1, $fileName2));
    }

    public function testTreeJSON1(): void
    {
         
        $fileName1 = $this->getFixtureFullPath("file3.json");
        $fileName2 = $this->getFixtureFullPath("file4.json");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result34.txt"), genDiff($fileName1, $fileName2));
    }

    public function testTreeYAML1(): void
    {
         
        $fileName1 = $this->getFixtureFullPath("file3.yml");
        $fileName2 = $this->getFixtureFullPath("file4.yaml");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result34.txt"), genDiff($fileName1, $fileName2));
    }
}
