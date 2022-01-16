<?php declare(strict_types=1);

namespace Tkui\Tests\Dialogs;

use Tkui\Dialogs\FontDialog;
use Tkui\FontManager;
use Tkui\Tests\TestCase;

class FontDialogTest extends TestCase
{
    /** @test */
    public function callback_is_registered()
    {
        $this->eval->expects($this->once())
            ->method('registerCallback');

        $fm = $this->createMock(FontManager::class);

        new FontDialog($this->createWindowStub(), $fm);
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

        $fm = $this->createMock(FontManager::class);

        (new FontDialog($this->createWindowStub(), $fm))->showModal();
    }
}