<?php

namespace PhpCli;

interface Command
{
    public static function getName(): string;
    public static function getDescription(): string;
    public function execute(Input $input, Output $output): int;
}
