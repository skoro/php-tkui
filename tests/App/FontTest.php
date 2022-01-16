<?php declare(strict_types=1);

namespace Tkui\Tests\App;

use InvalidArgumentException;
use Tkui\Font;
use Tkui\Tests\TestCase;
use SplObserver;

class FontTest extends TestCase
{
    /** @test */
    public function name_cannot_be_empty()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Font name cannot be empty.');

        new Font('', 1);
    }

    /** @test */
    public function font_size_cannot_be_negative()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Font size cannot be zero or negative.');

        new Font('test', -1);
    }

    /** @test */
    public function font_size_cannot_be_zero()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Font size cannot be zero or negative.');

        new Font('test', 0);
    }

    /** @test */
    public function notify_when_size_is_changed()
    {
        $observer = $this->createMock(SplObserver::class);
        $observer->expects($this->once())
                 ->method('update');

        $f = new Font('Test', 10);
        $f->attach($observer);

        $f->setSize(15);
    }

    /** @test */
    public function notify_when_style_is_changed()
    {
        $observer = $this->createMock(SplObserver::class);
        $observer->expects($this->exactly(4))
                 ->method('update');

        $f = new Font('Test', 10);
        $f->attach($observer);

        $f->setBold(true);
        $f->setItalic(true);
        $f->setOverstrike(true);
        $f->setUnderline(true);
    }

    /** @test */
    public function styles_initialization()
    {
        $f = new Font('test', 10, Font::BOLD, Font::UNDERLINE);

        $this->assertTrue($f->isBold());
        $this->assertTrue($f->isUnderline());
        $this->assertFalse($f->isItalic());
        $this->assertFalse($f->isOverstrike());
    }

    /** @test */
    public function regular_is_always_included_but_must_be_deleted_in_next_versions()
    {
        $f = new Font('test', 10, Font::ITALIC);

        $this->assertTrue($f->isItalic());
        $this->assertTrue($f->isRegular());
    }
}