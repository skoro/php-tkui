<?php declare(strict_types=1);

namespace Tkui\Tests\Dialogs;

use Tkui\Dialogs\DirectoryDialog;
use Tkui\Tests\TestCase;

class DirectoryDialogTest extends TestCase
{
    /** @test */
    public function show_dialog()
    {
        $this->tclEvalTest(1, [
            ['tk_chooseDirectory', '-parent', '.'],
        ]);

        (new DirectoryDialog($this->createWindowStub()))->showModal();
    }

    /** @test */
    public function dialog_with_properties()
    {
        $dir = dirname(__FILE__);
        $this->tclEvalTest(1, [
            ['tk_chooseDirectory', '-parent', '.', '-initialdir', $dir, '-title', 'Test'],
        ]);

        $d = new DirectoryDialog($this->createWindowStub(), [
            'title' => 'Test',
        ]);
        $d->initialDir = $dir;
        $d->showModal();
    }
}