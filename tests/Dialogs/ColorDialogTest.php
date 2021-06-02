<?php declare(strict_types=1);

namespace PhpGui\Tests\Dialogs;

use PhpGui\Dialogs\ColorDialog;
use PhpGui\Tests\TestCase;

class ColorDialogTest extends TestCase
{
    /** @test */
    public function show_dialog()
    {
        $this->tclEvalTest(1, [
            ['tk_chooseColor', '-parent', '.'],
        ]);

        (new ColorDialog($this->createWindowStub()))->showModal();
    }

    /** @test */
    public function dialog_with_properties()
    {
        $this->tclEvalTest(1, [
            ['tk_chooseColor', '-parent', '.', '-initialcolor', '#000000', '-title', 'Test'],
        ]);

        $d = new ColorDialog($this->createWindowStub(), [
            'title' => 'Test',
        ]);
        $d->initialColor = '#000000';
        $d->showModal();
    }
}