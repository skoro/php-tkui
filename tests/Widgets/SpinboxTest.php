<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Widgets\Spinbox;

class SpinboxTest extends TestCase
{
    /** @test */
    public function widget_created()
    {
        $this->tclEvalTest(2, [
            ['ttk::spinbox', $this->checkWidget('.spnb')],
            [$this->checkWidget('.spnb'), 'set', '10'],
        ]);

        new Spinbox($this->createWindowStub(), 10);
    }

    /** @test */
    public function with_limits()
    {
        $this->tclEvalTest(2, [
            ['ttk::spinbox', $this->checkWidget('.spnb'), '-from', '5', '-to', '10'],
            [$this->checkWidget('.spnb'), 'set', '5'],
        ]);

        new Spinbox($this->createWindowStub(), 5, [
            'from' => 5,
            'to' => 10,
        ]);
    }

    /** @test */
    public function value_as_list()
    {
        $this->tclEvalTest(2, [
            ['ttk::spinbox', $this->checkWidget('.spnb'), '-values', '{{One} {Two} {Three}}'],
            [$this->checkWidget('.spnb'), 'set', 'Two'],
        ]);

        new Spinbox($this->createWindowStub(), 'Two', [
            'values' => ['One', 'Two', 'Three'],
        ]);
    }
}