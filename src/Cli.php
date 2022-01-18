<?php

namespace Gendiff\Cli;

function start()
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

    $args = (new \Docopt\Handler)->handle($sdoc);
}
