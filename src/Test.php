<?php

namespace PhpCli;

class Test implements Command, UsesArguments
{
    public static function getName(): string
    {
        return 'test';
    }

    public static function getDescription(): string
    {
        return 'This is just a test!';
    }

    public function execute(Input $input, Output $output): int
    {
        if ($input->confirm('You up?')) {
            $output->line("All right!");
        } else {
            $output->line("Oh well");
        }

        return 0;
    }

    public function injectArguments(Arguments $arguments): void
    {
        // TODO: Implement injectArguments() method.
    }
}
