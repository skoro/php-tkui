<?php declare(strict_types=1);

namespace Tkui\Dialogs;

use Tkui\Options;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/getOpenFile.htm
 *
 * @property string $defaultExtension
 * @property FileType[] $fileTypes
 * @property string $initialDir
 * @property string $initialFile
 * @property string $message
 * @property bool $multiple
 * @property string $title
 * @property Window $parent
 * @property bool $confirmOverwrite
 */
class SaveFileDialog extends FileDialog
{
    /**
     * @inheritdoc
     */
    public function command(): string
    {
        return 'tk_getSaveFile';
    }

    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return parent::createOptions()->mergeAsArray([
            'confirmOverwrite' => null,
        ]);
    }
}