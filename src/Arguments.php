<?php

namespace PhpCli;

class Arguments
{
    private array $named_arguments = [];

    private array $ordered_arguments = [];

    private array $all_arguments = [];

    public function __construct(array $raw_argv)
    {
        foreach ($raw_argv as $index => $value) {
            if ($this->matchArgument($value, $matches)) {
                $name = $matches['name'];
                $argument = $matches['value'] ?? $matches['name'];

                $this->named_arguments[$name] = $argument;
                $this->all_arguments[$name] = $argument;
            } else {
                $this->ordered_arguments[$index] = $value;
                $this->all_arguments[$index] = $value;
            }
        }
    }

    private function matchArgument(string $value, ?array &$matches = []): bool
    {
        $is_a_match =
            preg_match("/^--(?'name'[^=]*)(=(?'value'.*))?$/", $value, $matches) === 1 ||
            preg_match("/^-(?'name'\w)$/i", $value, $matches) === 1;

        foreach (array_keys($matches) as $key) {
            if (! is_string($key)) {
                unset($matches[$key]);
            }
        }

        return $is_a_match;
    }

    public function getByName(string $name): ?string
    {
        return $this->named_arguments[$name] ?? null;
    }

    public function getByIndex(int $index): ?string
    {
        return $this->ordered_arguments[$index];
    }

    public function list(): array
    {
        return $this->all_arguments;
    }
}

