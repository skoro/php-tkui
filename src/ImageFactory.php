<?php declare(strict_types=1);

namespace PhpGui;

interface ImageFactory
{
    public function createFromFile(string $filename): Image;

    public function createFromBinary(string $data): Image;
}
