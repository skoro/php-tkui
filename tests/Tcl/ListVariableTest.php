<?php declare(strict_types=1);

namespace Tkui\Tests\Tcl;

use Tkui\Tests\TclInterp;
use Tkui\Tests\TestCase;

class ListVariableTest extends TestCase
{
    use TclInterp;

    /** @test */
    public function it_can_create_list_variable_in_tcl_interp(): void
    {
        $this->interp->createListVariable('test');
        $result = $this->interp->eval('set test');
        
        $this->assertNull($result);
    }

    /** @test */
    public function it_can_get_list_length(): void
    {
        $var = $this->interp->createListVariable('test');
        $values = range(1, random_int(99, 99999));
        $var->append(...$values);

        $this->assertEquals(count($values), $var->count());
    }
}
