<?php

use PhpCli\Arguments;
use PhpCli\Input;

require_once(__DIR__ . "/vendor/autoload.php");

$input = new Input();
$arguments = new Arguments($argv);

if ($arguments->getByName('holla')) {
    echo "HOLLA HOLLA HOLLA!\n";
}

if ($input->confirm('May I ask you something?')) {
    $answer = $input->prompt('What is your favorite food?');

    echo "{$answer} is fifty percent off today!\n";
}

