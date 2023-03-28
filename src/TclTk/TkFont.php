<?php declare(strict_types=1);

namespace Tkui\TclTk;

use Tkui\Font;

/**
 * Implementation of Tk Font.
 */
final class TkFont extends Font
{
    protected function asString(): string
    {
        $size = $this->getSize();

        return sprintf('{%s %s %s}',
            $this->asTclName(),
            $size > 0 ? $size : '',
            implode(' ', $this->getEnabledStyleNames())
        );
    }

    protected function asTclName(): string
    {
        return '{' . $this->getName() . '}';
    }

    public function getStyleNames(): array
    {
        return [
            self::STYLE_REGULAR => 'normal',
        ] + parent::getStyleNames();
    }

    public static function createFromFontOptions(TkFontOptions $fontOptions): static
    {
        $font = new static($fontOptions->family, (int) $fontOptions->size, self::STYLE_REGULAR);
        $font->setBold($fontOptions->weight === 'bold')
             ->setItalic($fontOptions->slant === 'italic')
             ->setUnderline((bool) $fontOptions->underline)
             ->setOverstrike((bool) $fontOptions->overstrike);
        return $font;
    }
}
