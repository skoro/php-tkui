<?php declare(strict_types=1);

namespace Tkui\TclTk;

use Tkui\ThemeManager;

/**
 * Implementation of Ttk style themes.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_style.htm
 */
class TkThemeManager implements ThemeManager
{
    private Interp $interp;

    public function __construct(Interp $interp)
    {
        $this->interp = $interp;
    }

    /**
     * @inheritdoc
     */
    public function themes(): array
    {
        $this->call('theme', 'names');
        return $this->interp->getListResult();
    }

    /**
     * @inheritdoc
     */
    public function useTheme(string $theme): self
    {
        $this->call('theme', 'use', Tcl::quoteString($theme));
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function currentTheme(): string
    {
        $this->call('theme', 'use');
        return $this->interp->getStringResult();
    }

    protected function call(...$args)
    {
        $this->interp->eval('ttk::style ' . implode(' ', $args));
    }
}