<?php declare(strict_types=1);

namespace Tkui\Tests\Tcl;

use Tkui\TclTk\Exceptions\TclInterpException;
use Tkui\Tests\TclInterp;
use Tkui\Tests\TestCase;

class VariableTest extends TestCase
{
    use TclInterp;

    /** @test */
    public function create_empty_var()
    {
        $var = $this->interp->createVariable('myVar');
        $this->assertEquals('', $var->asString());
    }

    /** @test */
    public function create_with_string_value()
    {
        $var = $this->interp->createVariable('myVar', NULL, 'abc');
        $this->assertEquals('abc', $var->asString());
    }

    /** @test */
    public function delete_var()
    {
        $var = $this->interp->createVariable('myVar', NULL, 'abc');
        $this->assertEquals('abc', $var->asString());
        
        unset($var);

        $this->expectException(TclInterpException::class);
        $this->expectExceptionMessage('Eval: can\'t read "myVar": no such variable');

        $this->interp->eval('set myVar');
    }

    /** @test */
    public function change_var()
    {
        $var = $this->interp->createVariable('myVar');
        $this->assertEquals('', $var->asString());
        $var->set('test');
        $this->assertEquals('test', $var->asString());
        $var->set(99);
        $this->assertEquals(99, $var->asInt());
        $var->set(TRUE);
        $this->assertEquals(TRUE, $var->asBool());
    }

    /** @test */
    public function convert_value_from_type_to_type()
    {
        $var = $this->interp->createVariable('myVar', NULL, '50');
        $this->assertEquals('50', $var->asString());
        $this->assertEquals(50, $var->asInt());
        $this->assertEquals(50.0, $var->asFloat());
        $this->assertEquals(TRUE, $var->asBool());
    }

    /** @test */
    public function default_value_cannot_be_got_as_int()
    {
        $var = $this->interp->createVariable('myVar');

        $this->expectException(TclInterpException::class);
        $this->expectExceptionMessage('GetLongFromObj: expected integer but got ""');

        $var->asInt();
    }

    /** @test */
    public function default_value_cannot_be_got_as_bool()
    {
        $var = $this->interp->createVariable('myVar');

        $this->expectException(TclInterpException::class);
        $this->expectExceptionMessage('GetBooleanFromObj: expected boolean value but got ""');

        $var->asBool();
    }
}