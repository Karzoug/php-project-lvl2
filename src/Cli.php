<?php

namespace Gendiff\Cli;

function input()
{
    $sdoc = <<<DOC
Generate diff

Usage:
    gendiff (-h|--help)
    gendiff (-v|--version)
    gendiff [--format <fmt>] <firstFile> <secondFile>
    
Options:
    -h --help                     Show this screen
    -v --version                  Show version
    --format <fmt>                Report format [default: stylish]
DOC;

    $args = \Docopt::handle($sdoc, array('version' => '1.0'));

    $fileName1 = $args['<firstFile>'];
    $fileName2 = $args['<secondFile>'];
    $format = $args['--format'];

    return ["fileName1" => $fileName1, "fileName2" => $fileName2, "format" => $format];
}

function output($data)
{
    echo $data;
}
