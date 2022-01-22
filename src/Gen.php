<?php

namespace Gendiff\Gen;

use Gendiff\Cli;
use Gendiff\IO;
use Gendiff\Diff;

use function Gendiff\Parsers\parse;
use function Gendiff\Formatters\format;

function run()
{
    $cliData = Cli\input();

    $diff = genDiff($cliData["fileName1"], $cliData["fileName2"], $cliData["format"]);

    Cli\output($diff);
}

function genDiff($fileName1, $fileName2, $formatOutput = "stylish")
{
    $file1Data = IO\getDataFromFile($fileName1);
    $file2Data = IO\getDataFromFile($fileName2);

    if (($file1Data === false) || ($file2Data === false)) {
        return;
    }

    $formatFile = "json";
    if (str_ends_with(strtolower($fileName1), ".yml") || str_ends_with(strtolower($fileName1), ".yaml")) {
        $formatFile = "yaml";
    }

    $dictFile1 = parse($file1Data, $formatFile);
    $dictFile2 = parse($file2Data, $formatFile);

    $diff = Diff\getDiff($dictFile1, $dictFile2);

    $formatDiff = format($diff, $formatOutput);

    return $formatDiff;
}
