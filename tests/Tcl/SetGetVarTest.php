<?php declare(strict_types=1);

namespace Tkui\Tests\Tcl;

use Tkui\TclTk\Exceptions\TclInterpException;
use Tkui\Tests\TclInterp;
use Tkui\Tests\TestCase;

class SetGetVarTest extends TestCase
{
    use TclInterp;

    /** @test */
    public function check_set_var_by_eval()
    {
        $this->tcl->setVar($this->interp, 'testVar', NULL, 'testValue');

        $this->interp->eval('set testVar');
        $this->assertEquals('testValue', $this->interp->getStringResult());
    }

    /** @test */
    public function check_set_array_var_by_eval()
    {
        $this->tcl->setVar($this->interp, 'myArr', 'first', 'array value');

        $this->interp->eval('set myArr(first)');
        $this->assertEquals('array value', $this->interp->getStringResult());
    }

    /** @test */
    public function namespace_var()
    {
        $this->tcl->setVar($this->interp, '::var1', '', 'in the global');

        $this->interp->eval('set ::var1');
        $this->assertEquals('in the global', $this->interp->getStringResult());
    }

    /** @test */
    public function get_var_from_ffi()
    {
        $this->tcl->setVar($this->interp, 'var1', NULL, 'abc');

        $obj = $this->tcl->getVar($this->interp, 'var1');
        $this->assertEquals('abc', $this->tcl->getStringFromObj($obj));
    }

    /** @test */
    public function get_array_var_from_ffi()
    {
        $this->tcl->setVar($this->interp, 'myArr', 'first', 'abc');

        $obj = $this->tcl->getVar($this->interp, 'myArr', 'first');
        $this->assertEquals('abc', $this->tcl->getStringFromObj($obj));
    }

    /** @test */
    public function get_non_exist_var()
    {
        $this->expectException(TclInterpException::class);
        $this->expectExceptionMessage('ObjGetVar2: can\'t read "must-be-error": no such variable');

        $this->tcl->getVar($this->interp, 'must-be-error');
    }
}