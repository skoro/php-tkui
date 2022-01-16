<?php declare(strict_types=1);

namespace Tkui\Tests\App;

use Tkui\TclTk\Interp;
use Tkui\Tests\TestCase;
use Tkui\TclTk\TkBindings;
use Tkui\Widgets\Buttons\Button;

class BindingsTest extends TestCase
{
    /** @test */
    public function create_bind_proc()
    {
        $interp = $this->createMock(Interp::class);
        $interp->expects($this->once())
               ->method('eval')
               ->with('bind .b1 <Control-a> PHP_Bind__b1_Control-a');

        $bindings = new TkBindings($interp);

        $btn = new Button($this->createWindowStub(), 'test');
        $bindings->bindWidget($btn, 'Control-a', function () {});
    }

    /** @test */
    public function allow_to_redefine_event_callback()
    {
        $interp = $this->createMock(Interp::class);
        $interp->expects($this->exactly(2))
               ->method('eval')
               ->with('bind .b2 <Control-a> PHP_Bind__b2_Control-a');

        $bindings = new TkBindings($interp);

        $btn = new Button($this->createWindowStub(), 'test');
        $bindings->bindWidget($btn, 'Control-a', function () {});
        $bindings->bindWidget($btn, 'Control-a', function () {});
    }

    /** @test */
    public function unbind_event()
    {
        $interp = $this->createMock(Interp::class);
        $interp->expects($this->once())
               ->method('eval')
               ->with('bind .b3 <Control-a> PHP_Bind__b3_Control-a');
        $interp->expects($this->once())
               ->method('deleteCommand')
               ->with('PHP_Bind__b3_Control-a');

        $bindings = new TkBindings($interp);

        $btn = new Button($this->createWindowStub(), 'test');
        $bindings->bindWidget($btn, 'Control-a', function () {});
        $bindings->unbindWidget($btn, 'Control-a');
    }
}