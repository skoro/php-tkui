<?php declare(strict_types=1);

namespace Tkui\TclTk;

use FFI\CData;

class ListVariable
{
    private CData $listObj;

    public function __construct(
        private readonly Interp $interp,
        public readonly string $name,
    ) {
        $this->listObj = $interp->callTcl('createListObj');
        $interp->callTcl('setVar', $name, null, $this->listObj);
    }

    public function append(...$values): static
    {
        foreach ($values as $value) {
            $this->interp->callTcl('addListElement', $this->listObj, $value);
        }
        return $this;
    }

    public function count(): int
    {
        return $this->interp->callTcl('getListLength', $this->listObj);
    }

    public function index(int $i)
    {
        $result = $this->interp->callTcl('getListIndex', $this->listObj, $i);
        return $this->interp->callTcl('getStringFromObj', $result);
    }
}
