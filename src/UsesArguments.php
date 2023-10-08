<?php

namespace PhpCli;

interface UsesArguments
{
    public function injectArguments(Arguments $arguments): void;
}
