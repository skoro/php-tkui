<?php declare(strict_types=1);

namespace Tkui\TclTk\Exceptions;

use Tkui\TclTk\Interp;

class TclInterpException extends TclException
{
    private string $result;

    public function __construct(
        private readonly Interp $interp,
        string $message
    ) {
        $this->result = $interp->getStringResult();
        parent::__construct($message . ': ' . $this->result);
    }

    public function getInterp(): Interp
    {
        return $this->interp;
    }

    public function getStringResult(): string
    {
        return $this->result;
    }
}