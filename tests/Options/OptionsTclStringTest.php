<?php declare(strict_types=1);

namespace Tkui\Tests\Unit;

use Tkui\TclTk\TclOptions;
use Tkui\Tests\TestCase;

class OptionsTclStringTest extends TestCase
{
    /** @test */
    public function it_can_be_converted_to_tcl_string(): void
    {
        $options = new TclOptions(['color' => 'red', 'width' => 25]);
        $this->assertEquals('-color red -width 25', (string) $options);
    }

    /** @test */
    public function it_ignores_option_case_in_converted_tcl_string(): void
    {
        $options = new TclOptions(['Color' => 'red', 'Width' => 25]);
        $this->assertEquals('-color red -width 25', (string) $options);
    }

    /** @test */
    public function it_ignores_options_with_null_values(): void
    {
        $options = new TclOptions(['color' => 'red', 'width' => null]);
        $this->assertEquals('-color red', (string) $options);
    }

    /** @test */
    public function it_converts_empty_strings_to_tcl_figure_brackets(): void
    {
        $options = new TclOptions(['color' => '', 'width' => '25']);
        $this->assertEquals('-color {} -width 25', (string) $options);
    }

    /** @test */
    public function it_converts_boolean_values(): void
    {
        $options = new TclOptions(['enabled' => true, 'disabled' => false]);
        $this->assertEquals('-enabled 1 -disabled 0', (string) $options);
    }

    /** @test */
    public function it_converts_numeric_values(): void
    {
        $options = new TclOptions(['size' => 25, 'density' => 10.9]);
        $this->assertEquals('-size 25 -density 10.9', (string) $options);
    }

    /** @test */
    public function it_quotes_text_options(): void
    {
        $options = new TclOptions(['text' => 'SomeText']);
        $this->assertEquals('-text {SomeText}', (string) $options);
    }

    /** @test */
    public function it_quotes_empty_text_option(): void
    {
        $options = new TclOptions(['text' => '']);
        $this->assertEquals('-text {}', (string) $options);
    }
}
