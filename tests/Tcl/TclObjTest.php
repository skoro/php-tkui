<?php declare(strict_types=1);

namespace TclTk\Tests\Tcl;

use TclTk\Exceptions\TclInterpException;
use TclTk\Tests\TestCase;

class TclObjTest extends TestCase
{
    /** @test */
    public function check_obj_string()
    {
        $tcl = $this->createTcl();
        $obj = $tcl->createStringObj('test tcl');

        $this->assertEquals('test tcl', $tcl->getStringFromObj($obj));
    }

    /** @test */
    public function obj_int()
    {
        $tcl = $this->createTcl();
        $interp = $tcl->createInterp();
        $obj = $tcl->createIntObj(1234567890);

        $this->assertEquals(1234567890, $tcl->getIntFromObj($interp, $obj));
    }

    /** @test */
    public function obj_bool_true()
    {
        $tcl = $this->createTcl();
        $interp = $tcl->createInterp();
        $obj = $tcl->createBoolObj(TRUE);

        $this->assertEquals(TRUE, $tcl->getBooleanFromObj($interp, $obj));
    }

    /** @test */
    public function obj_bool_false()
    {
        $tcl = $this->createTcl();
        $interp = $tcl->createInterp();
        $obj = $tcl->createBoolObj(FALSE);

        $this->assertEquals(FALSE, $tcl->getBooleanFromObj($interp, $obj));
    }

    /** @test */
    public function obj_float()
    {
        $tcl = $this->createTcl();
        $interp = $tcl->createInterp();
        $obj = $tcl->createFloatObj(108.91);

        $this->assertEquals(108.91, $tcl->getFloatFromObj($interp, $obj));
    }

    /** @test */
    public function int_convert_error()
    {
        $tcl = $this->createTcl();
        $obj = $tcl->createStringObj('error');

        $this->expectException(TclInterpException::class);
        $this->expectExceptionMessage('GetLongFromObj: expected integer but got "error"');

        $tcl->getIntFromObj($tcl->createInterp(), $obj);
    }

    /** @test */
    public function bool_convert_error()
    {
        $tcl = $this->createTcl();
        $obj = $tcl->createStringObj('test');

        $this->expectException(TclInterpException::class);
        $this->expectExceptionMessage('GetBooleanFromObj: expected boolean value but got "test"');

        $tcl->getBooleanFromObj($tcl->createInterp(), $obj);
    }
}