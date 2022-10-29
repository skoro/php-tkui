<?php declare(strict_types=1);

namespace Tkui\TclTk;

use FFI\CData;

class ListVariable
{
    private Interp $interp;
    private CData $listObj;
    private string $name;

    public function __construct(Interp $interp, string $name)
    {
        $this->interp = $interp;
        $this->name = $name;
        $this->listObj = $interp->tcl()->createListObj();
        $interp->tcl()->setVar($interp, $name, null, $this->listObj);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function append(...$values): self
    {
        foreach ($values as $value) {
            $this->interp->tcl()->addListElement($this->interp, $this->listObj, $value);
        }
        return $this;
    }

    public function count(): int
    {
        return $this->interp->tcl()->getListLength($this->interp, $this->listObj);
    }

    public function index(int $i)
    {
        $result = $this->interp->tcl()->getListIndex($this->interp, $this->listObj, $i);
        return $this->interp->tcl()->getStringFromObj($result);
    }
}