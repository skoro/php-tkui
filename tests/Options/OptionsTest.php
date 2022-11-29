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
    public function it_can_serialize_options_json(): void
    {
        $options = new Options(['color' => 'red', 'size' => 'bold']);
        $encoded = json_encode($options);
        $this->assertEquals(['color' => 'red', 'size' => 'bold'], json_decode($encoded, associative: true));
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
        $options = $options->with(new Options(['width' => 25, 'color' => 'cyan']));
        $this->assertEquals(['color' => 'cyan', 'width' => 25, 'size' => 'bold'], $options->toArray());
    }

    /** @test */
    public function it_can_merge_options_from_array(): void
    {
        $options = new Options(['color' => 'red', 'size' => 'bold']);
        $options = $options->with(['width' => 25, 'color' => 'cyan']);
        $this->assertEquals(['color' => 'cyan', 'width' => 25, 'size' => 'bold'], $options->toArray());
    }

    /** @test */
    public function it_can_return_only_specified_options(): void
    {
        $options = new Options(['color' => 'red', 'size' => 'bold', 'width' => 100]);
        $options = $options->withOnly('color', 'size');
        $this->assertEquals(['color' => 'red', 'size' => 'bold'], $options->toArray());
    }

    /** @test */
    public function it_can_iterate_over_foreach_loop(): void
    {
        $data = ['color' => 'red', 'size' => 'bold', 'width' => 100];
        $options = new Options($data);

        $result = [];
        foreach ($options as $k => $v) {
            $result[$k] = $v;
        }

        $this->assertEquals($data, $result);
    }

    /** @test */
    public function it_can_be_converted_to_a_string(): void
    {
        $options = new Options(['color' => 'red', 'size' => 'bold', 'width' => 100]);
        $this->assertEquals('color, size, width', (string) $options);
    }
}
