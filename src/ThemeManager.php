<?php declare(strict_types=1);

namespace TclTk;

/**
 * Ttk style.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_style.htm
 */
class ThemeManager
{
    private Interp $interp;

    public function __construct(Interp $interp)
    {
        $this->interp = $interp;
    }

    /**
     * Returns a list of names of installed ttk themes.
     *
     * @return string[]
     */
    public function themes(): array
    {
        $this->call('theme', 'names');
        return $this->interp->getListResult();
    }

    /**
     * @param string $name Ttk theme name.
     */
    public function useTheme(string $name): self
    {
        $this->call('theme', 'use', Tcl::quoteString($name));
        return $this;
    }

    /**
     * Returns the name of the current theme.
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