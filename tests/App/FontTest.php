<?php declare(strict_types=1);

namespace Tkui\Tests\App;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use Tkui\Font;
use Tkui\Tests\TestCase;
use SplObserver;

class FontTest extends TestCase
{
    /** @test */
    public function font_name_cannot_be_empty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Font name cannot be empty.');

        new Font('', 1);
    }

    /** @test */
    public function font_size_cannot_be_negative(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Font size cannot be zero or negative.');

        new Font('test', -1);
    }

    /** @test */
    public function font_size_cannot_be_zero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Font size cannot be zero or negative.');

        new Font('test', 0);
    }

    /** @test */
    public function it_notifies_observers_when_font_size_is_changed(): void
    {
        $f = new Font('Test', 10);

        /** @var MockObject|SplObserver */
        $observer = $this->createMock(SplObserver::class);
        $observer->expects($this->once())
                 ->method('update')
                 ->with($f);

        $f->attach($observer);
        $f->setSize(15);
    }

    /** @test */
    public function it_notifies_observers_when_font_name_is_changed(): void
    {
        $f = new Font('Old Font', 5);

        /** @var MockObject|SplObserver */
        $observer = $this->createMock(SplObserver::class);
        $observer->expects($this->once())
            ->method('update')
            ->with($f);

        $f->attach($observer);
        $f->setName('New Font');
    }

    /** @test */
    public function it_creates_font_with_regular_default_style(): void
    {
        $f = new Font('a', 1);

        $this->assertEquals([
            Font::STYLE_REGULAR => true,
            Font::STYLE_BOLD => false,
            Font::STYLE_ITALIC => false,
            Font::STYLE_OVERSTRIKE => false,
            Font::STYLE_UNDERLINE => false,
        ], $f->getStyles());
    }

    /** @test */
    public function it_can_set_font_style(): void
    {
        $f = new Font('f', 1, Font::STYLE_REGULAR);

        $this->assertFalse($f->isBold());
        $f->setBold(true);
        $this->assertEquals([
            Font::STYLE_REGULAR => false,
            Font::STYLE_BOLD => true,
            Font::STYLE_ITALIC => false,
            Font::STYLE_OVERSTRIKE => false,
            Font::STYLE_UNDERLINE => false,
        ], $f->getStyles());
        $this->assertTrue($f->isBold());
    }

    /** @test */
    public function it_can_unset_font_style(): void
    {
        $f = new Font('f', 1, Font::STYLE_UNDERLINE);

        $this->assertTrue($f->isUnderline());
        $f->setUnderline(false);
        $this->assertFalse($f->isUnderline());
    }

    /** @test */
    public function it_notifies_observers_when_font_style_is_changed(): void
    {
        $f = new Font('Test', 10);

        /** @var MockObject|SplObserver */
        $observer = $this->createMock(SplObserver::class);
        $observer->expects($this->exactly(4))
                 ->method('update')
                 ->with($f);

        $f->attach($observer);

        $f->setBold(true);
        $f->setItalic(true);
        $f->setOverstrike(true);
        $f->setUnderline(true);
    }

    /** @test */
    public function it_accepts_font_styles_in_constructor(): void
    {
        $f = new Font('a', 1, Font::STYLE_BOLD | Font::STYLE_ITALIC);
        $this->assertEquals([
            Font::STYLE_REGULAR => false,
            Font::STYLE_BOLD => true,
            Font::STYLE_ITALIC => true,
            Font::STYLE_OVERSTRIKE => false,
            Font::STYLE_UNDERLINE => false,
        ], $f->getStyles());
    }

    /** @test */
    public function font_object_can_be_converted_to_string(): void
    {
        $f1 = new Font('sans', 14, Font::STYLE_BOLD | Font::STYLE_ITALIC);
        $f2 = new Font('times', 12);

        $this->assertEquals('sans 14 bold,italic', (string) $f1);
        $this->assertEquals('times 12 regular', (string) $f2);
    }
}
