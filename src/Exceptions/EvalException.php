<?php declare(strict_types=1);

namespace TclTk\Exceptions;

use TclTk\Interp;

class EvalException extends TclInterpException
{
    private string $script;

    public function __construct(Interp $interp, string $script)
    {
        parent::__construct($interp, 'Eval');
        $this->script = $script;
    }

    public function getScript(): string
    {
        return $this->script;
    }
}