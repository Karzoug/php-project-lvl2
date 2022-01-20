<?php

namespace Gendiff\IO;

function getDataFromFiles($fileName1, $fileName2)
{
    if (!file_exists($fileName1) || !file_exists($fileName2)) {
        return false;
    }

    $data1 = file_get_contents($fileName1);
    $data2 = file_get_contents($fileName2);

    if ($data2 === false || $data1 === false) {
        return false;
    }

    return [$data1, $data2];
}
