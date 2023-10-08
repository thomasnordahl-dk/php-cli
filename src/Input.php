<?php

namespace PhpCli;

class Input
{
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
}
