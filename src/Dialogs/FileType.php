<?php declare(strict_types=1);

namespace TclTk\Dialogs;

use TclTk\Tcl;

class FileType
{
    private string $typeName;
    private array $extensions;
    private array $macTypes;

    public function __construct(string $typeName, $extensions, $macTypes = null)
    {
        $this->typeName = $typeName;
        if (! is_array($extensions)) {
            $this->extensions = array($extensions);
        }
        $this->macTypes = [];
        if ($macTypes) {
            if (!is_array($macTypes)) {
                $this->macTypes = array($macTypes);
            }
        }
    }

    public function __toString()
    {
        return sprintf('{%s} %s %s',
            $this->typeName,
            $this->getExtensionsString(),
            $this->getMacTypesString()
        );
    }

    public function getExtensionsString(): string
    {
        if (count($this->extensions) === 1) {
            switch ($this->extensions[0]) {
                case '*':
                    return '*';
                case '':
                    return '{}'; 
            }
        }
        return '{' . implode(' ', array_map(fn ($ext) => Tcl::quoteString($ext), $this->extensions)) . '}';
    }

    public function getMacTypesString(): string
    {
        if (! $this->macTypes) {
            return '';
        }
        return '{' . implode(' ', array_map(fn ($type) => Tcl::quoteString($type), $this->macTypes)) . '}';
    }
}