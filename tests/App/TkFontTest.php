<?php declare(strict_types=1);

namespace Tkui\Tests\App;

use Tkui\TclTk\TkFont;
use Tkui\Tests\TestCase;

class TkFontTest extends TestCase
{
    /** @test */
    public function serialize_to_tcl_list_with_styles()
    {
        $f = new TkFont('Noto Sans', 10, TkFont::BOLD, TkFont::ITALIC);

        $this->assertEquals('{{Noto Sans} 10 normal bold italic}', $f->asString());
    }

    /** @test */
    public function serialize_default_font()
    {
        $f = new TkFont('Noto Sans', 12);

        $this->assertEquals('{{Noto Sans} 12 normal}', $f->asString());
    }
}