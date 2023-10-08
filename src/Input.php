<?php

namespace PhpCli;

class Input
{
    private array $named_arguments = [];

    private array $ordered_arguments = [];

    public function __construct(array $raw_argv)
    {
        $this->loadArguments($raw_argv);
    }

    public function getArgument(string|int $key): ?string
    {
        return is_int($key) ? $this->ordered_arguments[$key] ?? null : $this->named_arguments[$key];
    }

    public function prompt(string $message): string
    {
        echo $message . "\n";

        $answer = fgets(STDIN);

        return mb_substr($answer, 0, -1);
    }

    public function confirm(string $question): bool
    {
        $answer = '';
        while ($answer !== 'yes' && $answer !== 'no') {
            echo "{$question} (yes/no) ";
            $answer = trim(strtolower(fgets(STDIN)));
        }

        return $answer === 'yes';
    }

    private function loadArguments(array $raw_argv): void
    {
        foreach ($raw_argv as $index => $value) {
            if ($this->matchNamedArgument($value, $matches)) {
                $name = $matches['name'];
                $argument = $matches['value'] ?? $matches['name'];

                $this->named_arguments[$name] = $argument;
            } else {
                $this->ordered_arguments[$index] = $value;
            }
        }
    }

    private function matchNamedArgument(string $value, ?array &$matches = []): bool
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
}
