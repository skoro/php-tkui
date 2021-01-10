<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use TclTk\Exceptions\EvalException;
use TclTk\Tests\TclInterp;
use TclTk\Tests\TestCase;
use TclTk\Tk;
use TclTk\Widgets\Buttons\Button;
use TclTk\Widgets\Window;

class WindowVarsTest extends TestCase
{
    use TclInterp {
        TclInterp::setUp as interpSetUp;
    }

    protected function setUp(): void
    {
        $this->interpSetUp();
        $tk = $this->createStub(Tk::class);
        $tk->method('interp')->willReturn($this->interp);
        $this->app->method('tk')->willReturn($tk);
    }

    /** @test */
    public function register_var_with_string()
    {
        $win = new Window($this->app, 'Test');
        $win->registerVar('myVar')->set('registered');

        $winId = $win->id() ?: 'w0';

        $this->interp->eval("set $winId(myVar)");
        $this->assertEquals('registered', $this->interp->getStringResult());
    }

    /** @test */
    public function register_with_widget()
    {
        $btn = new Button($this->createWindowStub(), 'Fake button');

        $win = new Window($this->app, 'Test');
        $win->registerVar($btn)->set('for button');

        $winId = $win->id() ?: 'w0';
        $btnId = $btn->path();

        $this->interp->eval("set $winId($btnId)");
        $this->assertEquals('for button', $this->interp->getStringResult());
    }

    /** @test */
    public function unregsiter_var()
    {
        $win = new Window($this->app, 'Test');
        $win->registerVar('var1')->set('value');

        $winId = $win->id() ?: 'w0';

        $this->interp->eval("set $winId(var1)");
        $this->assertEquals('value', $this->interp->getStringResult());

        $win->unregisterVar('var1');

        $this->expectException(EvalException::class);
        $this->expectExceptionMessage("Eval: can't read");

        $this->interp->eval("set $winId(var1)");
    }
}