<?php

namespace PhpCli;

class Output
{
    public function line(string $message): void
    {
        echo "{$message}\n";
    }

    public function write(string $message): void
    {
        echo $message;
    }

    public function ruler(): void
    {
        echo "-----------------------------------------------\n";
    }
}
