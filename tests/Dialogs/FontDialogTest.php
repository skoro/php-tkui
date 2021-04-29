<?php declare(strict_types=1);

namespace TclTk\Tests\Dialogs;

use TclTk\Dialogs\FontDialog;
use TclTk\Tests\TestCase;
use TclTk\Widgets\Window;

class FontDialogTest extends TestCase
{
    /** @test */
    public function callback_is_registered()
    {
        $win = $this->createMock(Window::class);
        $win->expects($this->once())
            ->method('registerCallback');

        new FontDialog($win);
    }

    /** @test */
    public function show_dialog()
    {
        $this->tclEvalTest(2, [
            ['tk', 'fontchooser', 'configure', '-parent', '.', '-command', 'test_callback'],
            ['tk', 'fontchooser', 'show'],
        ]);

        $win = $this->createWindowStub();
        $win->method('registerCallback')->willReturn('test_callback');

        (new FontDialog($win))->showModal();
    }
}