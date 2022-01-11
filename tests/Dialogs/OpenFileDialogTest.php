<?php declare(strict_types=1);

namespace Tkui\Tests\Dialogs;

use Tkui\Dialogs\OpenFileDialog;
use Tkui\Tests\TestCase;

class OpenFileDialogTest extends TestCase
{
    /** @test */
    public function show_dialog()
    {
        $this->tclEvalTest(1, [
            ['tk_getOpenFile', '-parent', '.'],
        ]);

        (new OpenFileDialog($this->createWindowStub()))->showModal();
    }

    /** @test */
    public function dialog_with_title()
    {
        $this->tclEvalTest(1, [
            ['tk_getOpenFile', '-parent', '.', '-title', 'Test'],
        ]);

        (new OpenFileDialog($this->createWindowStub(), [
            'title' => 'Test',
        ]))->showModal();
    }

    /** @test */
    public function with_file_types()
    {
        $this->tclEvalTest(1, [
            ['tk_getOpenFile', '-parent', '.', '-filetypes', '{{{TXT} {{.txt} {.text} {.md}} } {{Doc} {{.doc}} }}'],
        ]);

        $d = new OpenFileDialog($this->createWindowStub());
        $d->addFileType('TXT', ['.txt', '.text', '.md']);
        $d->addFileType('Doc', '.doc');
        $d->showModal();
    }
}