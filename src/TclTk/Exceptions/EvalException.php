<?php declare(strict_types=1);

namespace Tkui\TclTk\Exceptions;

use Tkui\TclTk\Interp;

class EvalException extends TclInterpException
{
    public function __construct(
        Interp $interp,
        public readonly string $script
    ) {
        parent::__construct($interp, 'Eval');
    }
}