<?php

namespace PhpCli;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;

class Console
{
    private array $commands = [];

    private array $descriptions = [];

    public function __construct(private array $argv, private readonly ContainerInterface $container)
    {

    }

    public function register(string $class_name): void
    {
        if (! is_subclass_of($class_name, Command::class)) {
            throw new InvalidArgumentException("Class name must be an implementation of " . Command::class);
        }

        $this->commands[$class_name::getName()] = $class_name;
        $this->descriptions[$class_name::getName()] = $class_name::getDescription();
    }

    public function run(): int
    {
        $input = new Input($this->argv);
        $output = new Output();

        $command_name = $input->getArgument(1);

        if (! $command_name) {
            $output->line("Command not given!");
            $this->showHelpText($output);

            return 1;
        }

        if (! isset($this->commands[$command_name])) {
            $output->line("Unknown command: \"{$command_name}\"");
            $this->showHelpText($output);

            return 0;
        }

        $command = $this->container->get($this->commands[$command_name]);

        if (! $command instanceof Command) {
            throw new \RuntimeException($command::class . " is not an instance of " . Command::class);
        }

        return $command->execute($input, $output);
    }

    private function showHelpText(Output $output): void
    {
        ksort($this->commands);
        $output->line("List of commands:");

        $output->ruler();

        foreach (array_keys($this->commands) as $name) {

            $output->line($name . ': "' . $this->descriptions[$name] . '"');
        }

        $output->ruler();
    }
}
