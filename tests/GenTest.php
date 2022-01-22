<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GenTest extends TestCase
{
    public function getFixtureFullPath($fixtureName)
    {
        $parts = [__DIR__, 'fixtures', $fixtureName];
        return realpath(implode('/', $parts));
    }

    public function testJsonStylish(): void
    {
        $fileName1 = $this->getFixtureFullPath("file1.json");
        $fileName2 = $this->getFixtureFullPath("file2.JSON");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result12Stylish.txt"), genDiff($fileName1, $fileName2));

        $fileName1 = $this->getFixtureFullPath("file1.json");
        $fileName2 = $this->getFixtureFullPath("blank.json");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result1blankStylish.txt"), genDiff($fileName1, $fileName2));

        $fileName1 = $this->getFixtureFullPath("file3.json");
        $fileName2 = $this->getFixtureFullPath("file4.json");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result34Stylish.txt"), genDiff($fileName1, $fileName2));
    }

    public function testYamlStylish(): void
    {
        $fileName1 = $this->getFixtureFullPath("file1.yml");
        $fileName2 = $this->getFixtureFullPath("file2.YAML");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result12Stylish.txt"), genDiff($fileName1, $fileName2));

        $fileName1 = $this->getFixtureFullPath("file1.yml");
        $fileName2 = $this->getFixtureFullPath("blank.yaml");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result1blankStylish.txt"), genDiff($fileName1, $fileName2));

        $fileName1 = $this->getFixtureFullPath("file3.yml");
        $fileName2 = $this->getFixtureFullPath("file4.yaml");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result34Stylish.txt"), genDiff($fileName1, $fileName2));
    }

    public function testJsonPlain(): void
    {
        $fileName1 = $this->getFixtureFullPath("file3.json");
        $fileName2 = $this->getFixtureFullPath("file4.json");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result34Plain.txt"), genDiff($fileName1, $fileName2, "plain"));
    }

    public function testYamlPlain(): void
    {
        $fileName1 = $this->getFixtureFullPath("file3.yml");
        $fileName2 = $this->getFixtureFullPath("file4.yaml");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result34Plain.txt"), genDiff($fileName1, $fileName2, "plain"));
    }

    public function testJsonJson(): void
    {
        $fileName1 = $this->getFixtureFullPath("file3.json");
        $fileName2 = $this->getFixtureFullPath("file4.json");
        $this->assertStringEqualsFile($this->getFixtureFullPath("result34Json.txt"), genDiff($fileName1, $fileName2, "json"));
    }
}
