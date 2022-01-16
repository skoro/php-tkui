<?php declare(strict_types=1);

namespace Tkui\Dialogs;

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
 */
class OpenFileDialog extends FileDialog
{
    /**
     * @inheritdoc
     */
    public function command(): string
    {
        return 'tk_getOpenFile';
    }
}