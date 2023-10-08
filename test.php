<?php

use mindplay\unbox\ContainerFactory;
use PhpCli\Console;
use PhpCli\Test;

require_once(__DIR__ . "/vendor/autoload.php");
$factory = new ContainerFactory();
$factory->register(Test::class);

$console = new Console($argv, $factory->createContainer());
$console->register(Test::class);
exit($console->run());



