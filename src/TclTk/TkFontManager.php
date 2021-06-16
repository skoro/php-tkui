<?php declare(strict_types=1);

namespace PhpGui\TclTk;

use PhpGui\Font;
use PhpGui\FontManager;
use PhpGui\Options;

/**
 * Tk Font Manager.
 *
 * The Tk implementation of Font Manager.
 */
class TkFontManager implements FontManager
{
    public const TK_DEFAULT_FONT = 'TkDefaultFont';
    public const TK_FIXED_FONT = 'TkFixedFont';

    private Interp $interp;

    public function __construct(Interp $interp)
    {
        $this->interp = $interp;
    }

    /**
     * @inheritdoc
     */
    public function getDefaultFont(): Font
    {
        return $this->createFontFromTclEvalResult(self::TK_DEFAULT_FONT);
    }

    /**
     * @inheritdoc
     */
    public function getFixedFont(): Font
    {
        return $this->createFontFromTclEvalResult(self::TK_FIXED_FONT);
    }

    /**
     * Creates a new font instance from the Tcl eval result.
     */
    protected function createFontFromTclEvalResult(string $name): TkFont
    {
        $this->interp->eval("font actual $name");
        $options = Options::createFromList($this->interp->getListResult());
        $font = new TkFont($options->family, (int) $options->size);
        $font->setBold($options->weight === 'bold')
             ->setItalic($options->slant === 'italic')
             ->setUnderline((bool) $options->underline)
             ->setOverstrike((bool) $options->overstrike);
        return $font;
    }

    /**
     * @inheritdoc
     */
    public function getFontNames(): array
    {
        $this->interp->eval('font families');
        return $this->interp->getListResult();
    }
}