<?php declare(strict_types=1);

namespace Tkui\TclTk;

use Tkui\Image;

/**
 * Tk implementation of Image.
 */
class TkImage implements Image
{
    private Interp $interp;
    private string $id;

    public function __construct(Interp $interp, string $id)
    {
        $this->interp = $interp;
        $this->id = $id;
    }

    public function width(): int
    {
        $this->interp->eval("image width {$this->id}");
        return (int) $this->interp->getStringResult();
    }

    public function height(): int
    {
        $this->interp->eval("image height {$this->id}");
        return (int) $this->interp->getStringResult();
    }

    public function __toString(): string
    {
        return $this->id;
    }
}