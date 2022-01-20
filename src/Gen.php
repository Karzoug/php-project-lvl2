<?php

namespace Gendiff\Gen;

use Gendiff\Cli;
use Gendiff\IO;
use Gendiff\Diff;

function run()
{
    $cliData = Cli\input();

    $diff = genDiff($cliData[0], $cliData[1]);

    Cli\output($diff);
}

function genDiff($fileName1, $fileName2)
{
    $filesData = IO\getDataFromFiles($fileName1, $fileName2);

    if ($filesData === false) {
        return;
    }

    return Diff\getDiff($filesData[0], $filesData[1]);
}
