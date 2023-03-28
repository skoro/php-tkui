<?php declare(strict_types=1);

namespace Tkui\TclTk;

use Tkui\Image;
use Tkui\ImageFactory;

/**
 * Tk implementation of Image Factory.
 */
class TkImageFactory implements ImageFactory
{
    public function __construct(
        private readonly Interp $interp,
    ) {
    }

    public function createFromFile(string $filename): Image
    {
        $this->interp->eval(sprintf('image create photo -file {%s}', $filename));
        return $this->createImage();
    }

    public function createFromBinary(string $data): Image
    {
        $encoded = base64_encode($data);
        $this->interp->eval(sprintf('image create photo -data {%s}', $encoded));
        return $this->createImage();
    }

    protected function createImage(): Image
    {
        $id = $this->interp->getStringResult();

        return new TkImage($this->interp, $id);
    }
}