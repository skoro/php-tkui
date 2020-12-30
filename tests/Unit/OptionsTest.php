<?php declare(strict_types=1);

namespace TclTk\Tests\Unit;

use InvalidArgumentException;
use TclTk\Options;
use TclTk\Tests\TestCase;

class OptionsTest extends TestCase
{
    /** @test */
    public function can_get_option_as_class_property()
    {
        $options = new Options(['text' => 'testing']);

        $this->assertEquals('testing', $options->text);
    }

    /** @test */
    public function can_set_option_as_class_property()
    {
        $options = new Options(['text' => 'init']);
        $options->text = 'changed';
        $this->assertEquals('changed', $options->text);
    }

    /** @test */
    public function cannot_get_not_registered_option()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("'text' is not widget option.");

        $options = new Options(['color' => 'blue']);
        $options->text;
    }

    /** @test */
    public function cannot_set_not_registered_option()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("'text' is not widget option.");

        $options = new Options(['color' => 'blue']);
        $options->text = 'changed';
    }

    /** @test */
    public function as_array()
    {
        $options = new Options(['color' => 'red', 'size' => 'bold']);
        $this->assertEquals(['color' => 'red', 'size' => 'bold'], $options->asArray());
    }

    /** @test */
    public function return_option_names()
    {
        $options = new Options(['color' => 'red', 'size' => 'bold']);
        $this->assertEquals(['color', 'size'], $options->names());
    }

    /** @test */
    public function merge()
    {
        $options = new Options(['color' => 'red', 'size' => 'bold']);
        $options->merge(new Options(['width' => 25, 'color' => 'cyan']));
        $this->assertEquals(['color' => 'cyan', 'width' => 25, 'size' => 'bold'], $options->asArray());
    }

    /** @test */
    public function only_options()
    {
        $options = new Options(['color' => 'red', 'size' => 'bold', 'width' => 100]);
        $this->assertEquals(['color' => 'red', 'size' => 'bold'], $options->only('color', 'size')->asArray());
    }
}