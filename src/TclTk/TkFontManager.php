<?php declare(strict_types=1);

namespace Tkui\TclTk;

use Tkui\Font;
use Tkui\FontManager;

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
    public function getTextWidth(string $text, Font $font): int
    {
        // TODO: TkApplication::encloseArg() must be used.
        $this->interp->eval(sprintf('font metrics %s %s', (string) $font, Tcl::quoteString($text)));
        return (int) $this->interp->getStringResult();
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
        $fontOptions = TkFontOptions::createFromList($this->interp->getListResult());
        return TkFont::createFromFontOptions($fontOptions);
    }

    /**
     * @inheritdoc
     */
    public function getFontNames(): array
    {
        $this->interp->eval('font families');
        return $this->interp->getListResult();
    }

    /**
     * @inheritdoc
     *
     * @param string $fontSpec A Tcl list of the font specification.
     *                         For example: {{Noto Sans} 72 bold italic overstrike}
     */
    public function createFontFromString(string $fontSpec): Font
    {
        return $this->createFontFromTclEvalResult($fontSpec);
    }
}