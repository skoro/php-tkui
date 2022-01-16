<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\TclTk\Variable;
use Tkui\Widgets\Buttons\CheckButton;

class CheckButtonTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $varStub = $this->createStub(Variable::class);
        $varStub->method('__toString')->willReturn('var');
        $this->eval->method('registerVar')->willReturn($varStub);

        $this->tclEvalTest(2, [
            ['ttk::checkbutton', $this->checkWidget('.chk'), '-text', '{Test}'],
            [$this->checkWidget('.chk'), 'configure', '-variable', 'var'],
        ]);

        new CheckButton($this->createWindowStub(), 'Test');
    }

    /** @test */
    public function select_set_true()
    {
        $varMock = $this->createMock(Variable::class);
        $varMock->expects($this->exactly(2))
            ->method('set')
            ->withConsecutive([false], [true]);

        $this->eval->method('registerVar')->willReturn($varMock);

        $cb = new CheckButton($this->createWindowStub(), 'Test', false);
        $cb->select();
    }

    /** @test */
    public function deselect_set_false()
    {
        $varMock = $this->createMock(Variable::class);
        $varMock->expects($this->exactly(2))
            ->method('set')
            ->withConsecutive([true], [false]);

        $this->eval->method('registerVar')->willReturn($varMock);
    
        $cb = new CheckButton($this->createWindowStub(), 'Test', true);
        $cb->deselect();
    }
}