<?php declare(strict_types=1);

namespace Tkui\Tests\Unit;

use Tkui\Options;
use Tkui\Tests\TestCase;

class OptionsTclStringTest extends TestCase
{
    /** @test */
    public function convert_options_to_tcl_string()
    {
        $options = new Options(['color' => 'red', 'width' => 25]);
        $this->assertEquals('-color red -width 25', $options->asTcl());
    }

    /** @test */
    public function ignore_option_case_during_tcl_string()
    {
        $options = new Options(['Color' => 'red', 'Width' => 25]);
        $this->assertEquals('-color red -width 25', $options->asTcl());
    }

    /** @test */
    public function skip_nullable_options()
    {
        $options = new Options(['color' => 'red', 'width' => null]);
        $this->assertEquals('-color red', $options->asTcl());
    }

    /** @test */
    public function empty_strings()
    {
        $options = new Options(['color' => '', 'width' => '25']);
        $this->assertEquals('-color {} -width 25', $options->asTcl());
    }

    /** @test */
    public function boolean_values()
    {
        $options = new Options(['enabled' => true, 'disabled' => false]);
        $this->assertEquals('-enabled 1 -disabled 0', $options->asTcl());
    }

    /** @test */
    public function numeric_values()
    {
        $options = new Options(['size' => 25, 'density' => 10.9]);
        $this->assertEquals('-size 25 -density 10.9', $options->asTcl());
    }

    /** @test */
    public function class_conversion_to_tcl_string()
    {
        $options = new Options(['color' => 'red', 'width' => 25]);
        $this->assertEquals('-color red -width 25', (string) $options);
    }

    /** @test */
    public function text_option_is_always_quotted()
    {
        $options = new Options(['text' => 'SomeText']);
        $this->assertEquals('-text {SomeText}', $options->asTcl());
    }

    /** @test */
    public function empty_text_is_also_quotted()
    {
        $options = new Options(['text' => '']);
        $this->assertEquals('-text {}', $options->asTcl());
    }
}