<?php declare(strict_types=1);

namespace TclTk\Exceptions;

class EvalException extends TclException
{
    private string $script;
    private string $error;

    public function __construct(string $script, string $error)
    {
        parent::__construct('Eval error: ' . $error);
        $this->script = $script;
        $this->error = $error;
    }

    public function getScript(): string
    {
        return $this->script;
    }

    public function getError(): string
    {
        return $this->error;
    }
}