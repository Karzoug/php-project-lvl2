<?php

namespace Gendiff\Cli;

function start()
{
    $sdoc = <<<DOC
Generate diff

Usage:
  gendiff (-h|--help)
  gendiff (-v|--version)

Options:
  -h --help                     Show this screen
  -v --version                  Show version

DOC;

    $args = (new \Docopt\Handler)->handle($sdoc);
}
