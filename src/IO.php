<?php

namespace Differ\IO;

function getDataFromFile(string $fileName)
{
    if (!file_exists($fileName)) {
        return false;
    }

    $data = file_get_contents($fileName);

    if ($data === false) {
        return false;
    }

    return $data;
}
