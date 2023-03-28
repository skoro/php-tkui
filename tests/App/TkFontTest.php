<?php declare(strict_types=1);

namespace Tkui\Tests\App;

use Tkui\TclTk\TkFont;
use Tkui\TclTk\TkFontOptions;
use Tkui\Tests\TestCase;

class TkFontTest extends TestCase
{
    /** @test */
    public function it_serializes_tkfont_to_tcl_list_with_styles(): void
    {
        $f = new TkFont('Noto Sans', 10, TkFont::STYLE_BOLD | TkFont::STYLE_ITALIC);

        $this->assertEquals('{{Noto Sans} 10 bold italic}', (string) $f);
    }

    /** @test */
    public function it_serializes_regular_style_to_normal(): void
    {
        $f = new TkFont('Noto Sans', 12, TkFont::STYLE_REGULAR);

        $this->assertEquals('{{Noto Sans} 12 normal}', (string) $f);
    }

    /** @test */
    public function it_creates_tkfont_from_fontoptions_with_default_styles_name_and_size(): void
    {
        $options = new TkFontOptions([
            'family' => 'Droid Sans Fallback',
            'size' => '16',
            'weight' => 'normal',
            'slant' => 'roman',
            'underline' => '0',
            'overstrike' => '0',
        ]);
        $font = TkFont::createFromFontOptions($options);

        $this->assertEquals([
            TkFont::STYLE_REGULAR => true,
            TkFont::STYLE_BOLD => false,
            TkFont::STYLE_ITALIC => false,
            TkFont::STYLE_OVERSTRIKE => false,
            TkFont::STYLE_UNDERLINE => false,
        ], $font->getStyles());

        $this->assertEquals('Droid Sans Fallback', $font->getName());
        $this->assertEquals(16, $font->getSize());
    }

    /** @test */
    public function it_creates_tkfont_from_fontoptions_with_specified_styles(): void
    {
        $options = new TkFontOptions([
            'family' => 'DejaVu Sans Mono',
            'size' => '14',
            'weight' => 'bold',
            'slant' => 'italic',
            'underline' => '1',
            'overstrike' => '1',
        ]);
        $font = TkFont::createFromFontOptions($options);

        $this->assertEquals([
            TkFont::STYLE_REGULAR => false,
            TkFont::STYLE_BOLD => true,
            TkFont::STYLE_ITALIC => true,
            TkFont::STYLE_OVERSTRIKE => true,
            TkFont::STYLE_UNDERLINE => true,
        ], $font->getStyles());
    }
}
