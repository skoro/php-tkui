<?php declare(strict_types=1);

namespace Tkui\Dialogs;

use Tkui\Options;
use Tkui\Widgets\Window;

/**
 * @property string $defaultExtension
 * @property FileType[] $fileTypes
 * @property string $initialDir
 * @property string $initialFile
 * @property string $message
 * @property bool $multiple
 * @property string $title
 * @property Window $parent
 */
abstract class FileDialog extends Dialog
{
    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return parent::createOptions()->mergeAsArray([
            'defaultExtension' => null,
            'fileTypes' => null,
            'initialDir' => null,
            'initialFile' => null,
            'message' => null,
            'multiple' => null,
            'title' => null,
        ]);
    }

    /**
     * @param string|string[] $extensions
     * @param string|string[] $macTypes
     */
    public function addFileType(string $typeName, $extensions, $macTypes = null): self
    {
        $types = $this->fileTypes;
        $types[] = new FileType($typeName, $extensions, $macTypes);
        $this->fileTypes = $types;
        return $this;
    }
}