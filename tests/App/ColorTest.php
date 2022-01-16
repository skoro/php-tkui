<?php declare(strict_types=1);

namespace Tkui\Tests;

use InvalidArgumentException;
use Tkui\Color;

class ColorTest extends TestCase
{
    /** @test */
    public function init_from_rgb_and_checking_rgb_values()
    {
        $color = Color::fromRgb(0, 255, 127);
        $this->assertEquals(0, $color->red());
        $this->assertEquals(255, $color->green());
        $this->assertEquals(127, $color->blue());
    }

    /** @test */
    public function color_rgb_string()
    {
        $color = Color::fromRgb(0, 255, 127);
        $this->assertEquals('rgb(0, 255, 127)', $color->toRgbString());
    }

    /** @test */
    public function init_from_hex_and_checking_rgb_values()
    {
        $color = Color::fromHex('#00ff7f');
        $this->assertEquals(0, $color->red());
        $this->assertEquals(255, $color->green());
        $this->assertEquals(127, $color->blue());
    }

    /** @test */
    public function convert_rgb_to_hex_string()
    {
        $color = Color::fromRgb(0, 255, 127);
        $this->assertEquals('#00ff7f', $color->toHexString());
    }

    /** @test */
    public function string_casting_to_hex_string()
    {
        $color = Color::fromRgb(0, 255, 127);
        $this->assertEquals('#00ff7f', (string) $color);
    }

    /** @test */
    public function invalid_hex_value()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid color hex value: ');

        Color::fromHex('#zzxxww');
    }

    /** @test */
    public function hex_value_must_start_with_sharp()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid color hex value: ');

        Color::fromHex('000000');
    }

    /** @test */
    public function red_must_be_unsigned_byte()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument must be unsigned byte but got: 999');

        Color::fromRgb(999, 0, 250);
    }

    /** @test */
    public function green_must_be_unsigned_byte()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument must be unsigned byte but got: 999');

        Color::fromRgb(0, 999, 250);
    }

    /** @test */
    public function blue_must_be_unsigned_byte()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument must be unsigned byte but got: 256');

        Color::fromRgb(0, 140, 256);
    }

    /** @test */
    public function color_component_cannot_be_negative_value()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument must be unsigned byte but got: -5');

        Color::fromRgb(0, -5, 0);
    }
}