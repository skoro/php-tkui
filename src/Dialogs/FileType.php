<?php declare(strict_types=1);

namespace Tkui\Dialogs;

use Tkui\TclTk\Tcl;

// TODO: implement Stringable
/**
 * File types filter for file dialogs.
 */
class FileType
{
    private string $typeName;
    /** @var string[] */
    private array $extensions = [];
    /** @var string[] */
    private array $macTypes = [];

    /**
     * @param array|string $extensions
     * @param array|string $macTypes
     */
    public function __construct(string $typeName, $extensions, $macTypes = null)
    {
        $this->typeName = $typeName;
        if (! is_array($extensions)) {
            $extensions = array($extensions);
        }
        $this->extensions = $extensions;
        if ($macTypes) {
            if (! is_array($macTypes)) {
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

    public function getTypeName(): string
    {
        return $this->typeName;
    }

    /**
     * @return string[]
     */
    public function getExtensions(): array
    {
        return $this->extensions;
    }

    /**
     * @return string[]
     */
    public function getMacTypes(): array
    {
        return $this->macTypes;
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
