<?php declare(strict_types=1);

namespace Tkui\TclTk\Exceptions;

use Tkui\TclTk\Interp;

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