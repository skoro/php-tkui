<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use PHPUnit\Framework\MockObject\Stub\Stub;
use TclTk\Tests\TestCase;
use TclTk\Variable;
use TclTk\Widgets\Buttons\CheckButton;
use TclTk\Widgets\TkWidget;

class CheckButtonTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(2, [
            ['ttk::checkbutton', $this->checkWidget('.chk'), '-text', '{Test}'],
            [$this->checkWidget('.chk'), 'configure', '-variable', 'var'],
        ]);

        /** @var TkWidget|Stub $win */
        $win = $this->createWindowStub();
        $varStub = $this->createStub(Variable::class);
        $varStub->method('__toString')->willReturn('var');
        $win->method('registerVar')->willReturn($varStub);

        new CheckButton($win, 'Test');
    }

    /** @test */
    public function select_set_true()
    {
        $varMock = $this->createMock(Variable::class);
        $varMock->expects($this->exactly(2))
            ->method('set')
            ->withConsecutive([false], [true]);

        $win = $this->createWindowStub();
        $win->method('registerVar')->willReturn($varMock);

        $cb = new CheckButton($win, 'Test', false);
        $cb->select();
    }

    /** @test */
    public function deselect_set_false()
    {
        $varMock = $this->createMock(Variable::class);
        $varMock->expects($this->exactly(2))
            ->method('set')
            ->withConsecutive([true], [false]);

        $win = $this->createWindowStub();
        $win->method('registerVar')->willReturn($varMock);

        $cb = new CheckButton($win, 'Test', true);
        $cb->deselect();
    }
}