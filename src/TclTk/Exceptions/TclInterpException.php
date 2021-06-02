<?php declare(strict_types=1);

namespace PhpGui\TclTk\Exceptions;

use PhpGui\TclTk\Interp;

class TclInterpException extends TclException
{
    private Interp $interp;
    private string $result;

    public function __construct(Interp $interp, string $message)
    {
        $this->result = $interp->getStringResult();
        parent::__construct($message . ': ' . $this->result);
        $this->interp = $interp;
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