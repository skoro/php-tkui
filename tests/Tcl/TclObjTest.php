<?php declare(strict_types=1);

namespace Tkui\Tests\Tcl;

use Tkui\TclTk\Exceptions\TclInterpException;
use Tkui\Tests\TclInterp;
use Tkui\Tests\TestCase;

class TclObjTest extends TestCase
{
    use TclInterp;

    /** @test */
    public function check_obj_string()
    {
        $obj = $this->tcl->createStringObj('test tcl');
        $this->assertEquals('test tcl', $this->tcl->getStringFromObj($obj));
    }

    /** @test */
    public function obj_int()
    {
        $obj = $this->tcl->createIntObj(1234567890);
        $this->assertEquals(1234567890, $this->tcl->getIntFromObj($this->interp, $obj));
    }

    /** @test */
    public function obj_bool_true()
    {
        $obj = $this->tcl->createBoolObj(TRUE);
        $this->assertEquals(TRUE, $this->tcl->getBooleanFromObj($this->interp, $obj));
    }

    /** @test */
    public function obj_bool_false()
    {
        $obj = $this->tcl->createBoolObj(FALSE);
        $this->assertEquals(FALSE, $this->tcl->getBooleanFromObj($this->interp, $obj));
    }

    /** @test */
    public function obj_float()
    {
        $obj = $this->tcl->createFloatObj(108.91);
        $this->assertEquals(108.91, $this->tcl->getFloatFromObj($this->interp, $obj));
    }

    /** @test */
    public function int_convert_error()
    {
        $obj = $this->tcl->createStringObj('error');

        $this->expectException(TclInterpException::class);
        $this->expectExceptionMessage('GetLongFromObj: expected integer but got "error"');

        $this->tcl->getIntFromObj($this->tcl->createInterp(), $obj);
    }

    /** @test */
    public function bool_convert_error()
    {
        $obj = $this->tcl->createStringObj('test');

        $this->expectException(TclInterpException::class);
        $this->expectExceptionMessage('GetBooleanFromObj: expected boolean value but got "test"');

        $this->tcl->getBooleanFromObj($this->tcl->createInterp(), $obj);
    }
}