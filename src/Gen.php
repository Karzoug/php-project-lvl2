<?php

namespace Differ\Differ;

use Differ\Cli;
use Differ\IO;
use Differ\Diff;

use function Differ\Parsers\parse;
use function Differ\Formatters\format;

function run()
{
    $cliData = Cli\input();

    $diff = genDiff($cliData["fileName1"], $cliData["fileName2"], $cliData["format"]);

    Cli\output($diff); /** @phpstan-ignore-line */
}

function genDiff(string $fileName1, string $fileName2, string $formatOutput = "stylish")
{
    $file1Data = IO\getDataFromFile($fileName1);
    $file2Data = IO\getDataFromFile($fileName2);

    if (($file1Data === false) || ($file2Data === false)) {
        return;
    }

    if (str_ends_with(strtolower($fileName1), ".yml") || str_ends_with(strtolower($fileName1), ".yaml")) {
        $formatFile = "yaml";
    } else {
        $formatFile = "json";
    }

    $dictFile1 = parse($file1Data, $formatFile);
    $dictFile2 = parse($file2Data, $formatFile);

    $diff = Diff\getDiff($dictFile1, $dictFile2);

    $formatDiff = format($diff, $formatOutput);

    return $formatDiff;
}
