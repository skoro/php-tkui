<?php declare(strict_types=1);

namespace TclTk\Tests\Dialogs;

use TclTk\Dialogs\FontDialog;
use TclTk\Tests\TestCase;

class FontDialogTest extends TestCase
{
    /** @test */
    public function callback_is_registered()
    {
        $this->eval->expects($this->once())
            ->method('registerCallback');

        new FontDialog($this->createWindowStub());
    }

    /** @test */
    public function show_dialog()
    {
        $this->tclEvalTest(2, [
            ['tk', 'fontchooser', 'configure', '-parent', '.', '-command', 'test_callback'],
            ['tk', 'fontchooser', 'show'],
        ]);

        $this->eval->expects($this->once())
            ->method('registerCallback')
            ->willReturn('test_callback');

        (new FontDialog($this->createWindowStub()))->showModal();
    }
}