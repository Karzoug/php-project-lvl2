<?php

namespace Gendiff\Gen;

use Gendiff\Cli;
use Gendiff\IO;
use Gendiff\Diff;

function run()
{
    $cliData = Cli\input();
    $filesData = IO\getDataFromFiles($cliData["fileName1"], $cliData["fileName2"]);

    if ($filesData === false) {
        return;
    }

    $diff = Diff\getDiff($filesData[0], $filesData[1]);

    Cli\output($diff);
}
