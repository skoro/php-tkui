<?php declare(strict_types=1);

namespace PhpGui\Dialogs;

use PhpGui\Options;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/chooseDirectory.htm
 *
 * @property string $initialDir
 * @property string $message
 * @property bool $mustExist
 * @property string $title
 */
class DirectoryDialog extends Dialog
{
    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return parent::createOptions()->mergeAsArray([
            'initialDir' => null,
            'message' => null,
            'mustExist' => null,
            'title' => null,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function command(): string
    {
        return 'tk_chooseDirectory';
    }
}