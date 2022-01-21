<?php

namespace Gendiff\Gen;

use Gendiff\Cli;
use Gendiff\IO;
use Gendiff\Diff;

use function Gendiff\Parsers\parse;

function run()
{
    $cliData = Cli\input();

    $diff = genDiff($cliData["fileName1"], $cliData["fileName2"]);

    Cli\output($diff);
}

function genDiff($fileName1, $fileName2)
{
    $file1Data = IO\getDataFromFile($fileName1);
    $file2Data = IO\getDataFromFile($fileName2);

    if (($file1Data === false) || ($file2Data === false)) {
        return;
    }

    $format = "json";
    if (str_ends_with(strtolower($fileName1), ".yml") || str_ends_with(strtolower($fileName1), ".yaml")) {
        $format = "yaml";
    }

    $dictFile1 = parse($file1Data, $format);
    $dictFile2 = parse($file2Data, $format);

    return Diff\getDiff($dictFile1, $dictFile2);
}
