<?php declare(strict_types=1);

namespace Tkui\Tests\Unit;

use Tkui\Exceptions\OptionNotFoundException;
use Tkui\Options;
use Tkui\Tests\TestCase;

class OptionsTest extends TestCase
{
    /** @test */
    public function can_get_option_as_class_property(): void
    {
        $options = new Options(['text' => 'testing']);

        $this->assertEquals('testing', $options->text); /** @phpstan-ignore-line */
    }

    /** @test */
    public function can_set_option_as_class_property(): void
    {
        $options = new Options(['text' => 'init']);
        $options->text = 'changed'; /** @phpstan-ignore-line */
        $this->assertEquals('changed', $options->text);
    }

    /** @test */
    public function cannot_get_not_registered_option(): void
    {
        $this->expectException(OptionNotFoundException::class);
        $this->expectExceptionMessage('"text" not found');

        $options = new Options(['color' => 'blue']);
        $options->text; /** @phpstan-ignore-line */
    }

    /** @test */
    public function cannot_set_not_registered_option(): void
    {
        $this->expectException(OptionNotFoundException::class);
        $this->expectExceptionMessage('"text" not found');

        $options = new Options(['color' => 'blue']);
        $options->text = 'changed'; /** @phpstan-ignore-line */
    }

    /** @test */
    public function it_can_serialize_options_as_array(): void
    {
        $options = new Options(['color' => 'red', 'size' => 'bold']);
        $this->assertEquals(['color' => 'red', 'size' => 'bold'], $options->asArray());
    }

    /** @test */
    public function it_returns_option_names(): void
    {
        $options = new Options(['color' => 'red', 'size' => 'bold']);
        $this->assertEquals(['color', 'size'], $options->names());
    }

    /** @test */
    public function it_can_merge_options_from_another_options_instance(): void
    {
        $options = new Options(['color' => 'red', 'size' => 'bold']);
        $options->merge(new Options(['width' => 25, 'color' => 'cyan']));
        $this->assertEquals(['color' => 'cyan', 'width' => 25, 'size' => 'bold'], $options->asArray());
    }

    /** @test */
    public function it_can_return_only_specified_options(): void
    {
        $options = new Options(['color' => 'red', 'size' => 'bold', 'width' => 100]);
        $this->assertEquals(['color' => 'red', 'size' => 'bold'], $options->only('color', 'size')->asArray());
    }
}
